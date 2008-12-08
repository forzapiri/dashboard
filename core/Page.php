<?php

class Page {
	
	public $tables = array();
	public $pointer = null;
	public $actionspointer = null;
	public $heading = array();
	public $names = array();
	public $actions = array();
	public $showcreate = array();
	public $link = array();
	public $filter = array();
	public $pre = array();
	public $post = array();
	public $ajax = array();
	public $renderer = array();
	public $order = array();
	
	public $perPage = 10;
	
	private $user = null;
	
	public function __construct() {
		$this->user =& $_SESSION['authenticated_user'];
	}
	
	public function &with( $class ) {
		$this->pointer = $class;
		return $this;
	}
	
	public function &show(Array $properties) {
		$this->tables[$this->pointer] = $properties;
		if (!isset($this->showcreate[$this->pointer])) {
			$this->showcreate[$this->pointer] = true;
		}
		return $this;
	}
	
	public function &heading( $title ) {
		$this->heading[$this->pointer] = $title;
		return $this;
	}
	
	public function &orderBy( $order ) {
		$this->order[$this->pointer] = $order;
		return $this;
	}
	
	public function &name( $name ) {
		$this->names[$this->pointer] = $name;
		return $this;
	}
	
	public function &on( $event ) {
		$this->actionspointer = $event;
		return $this;
	}
	
	public function &action( $action ) {
		$this->actions[$this->pointer][$this->actionspointer] = $action;
		return $this;
	}
	
	public function &link(Array $link) {
		$this->link[$this->pointer] = $link;
		return $this;
	}
	
	public function &filter($filter) {
		$this->filter[$this->pointer] = $filter;
		return $this;
	}
	
	public function &noAJAX() {
		$this->ajax[$this->actionspointer] = false;
		return $this;
	}
	
	public function &pre($html) {
		$this->pre[$this->pointer] = $html;
		return $this;
	}
	
	public function &post($html) {
		$this->post[$this->pointer] = $html;
		return $this;
	}
	
	public function &showCreate( $bool ) {
		$this->showcreate[$this->pointer] = $bool;
		return $this;
	}
	
	public function error($type) {
		return 'error '.$type;
	}
	
	public function &renderer($smarty, $template) {
		if (isset($this->actionspointer)) {
			$this->renderer[$this->pointer][$this->actionspointer] = array($smarty, $template);
		} else {
			$this->renderer[$this->pointer] = array($smarty, $template);
		}
		return $this;
	}
	
	public function getName() {
		if (isset($this->names[$this->pointer])) return $this->names[$this->pointer];
		return $this->pointer;
	}
	
	public function catchActions() {
		if (!isset($_REQUEST['section']) && !isset($_REQUEST['action'])) return; 
		
		if (isset($_REQUEST['section'])) {
			$this->pointer = $_REQUEST['section'];
			$type = $_REQUEST['section'];
		} else {
			$type = $this->pointer;
		}
		
		if (isset($this->actions[$this->pointer][@$_REQUEST['action']])) {
			$this->pointer = $this->actions[$this->pointer][$_REQUEST['action']];
			return;
		}
		
		$idField = call_user_func(array($type, 'quickformPrefix'));
		$i = call_user_func(array($type, 'make'), $type, @$_REQUEST[$idField . 'id']);
		switch(@$_REQUEST['action']) {
			case 'toggle':
				if ($this->user->hasPerm($this->pointer, 'addedit')) $i->toggle();
				break;
			case 'delete':
				if ($this->user->hasPerm($this->pointer, 'delete')) $i->delete();
				break;
			case 'add':
			case 'addedit':
				$form = $i->getAddEditForm('/admin/' . $_REQUEST['module']);
				if ($i->get('id') == null) {
					$el =& $form->removeElement($idField . 'id');
				}
				if (!$form->isProcessed()) {
					if ($this->user->hasPerm($this->pointer, 'addedit')) {
						if (isset($this->renderer[$this->pointer][$this->actionspointer])) {
							$r = $this->renderer[$this->pointer][$this->actionspointer];
							$r[0]->assign('item', $i);
							$r[0]->assign('form', $form);
							return $r[0]->fetch($r[1]);
						}
						return $form->display();
					}
				}
				break;
		}
		
		return false;
	}
	
	public function render() {
		$type = isset($_REQUEST['X-ResultType']) ? $_REQUEST['X-ResultType'] : 'html';

		if ($r = $this->catchActions()) return $r;
		
		$html = '';
		$where = null;
		if (isset($this->link[$this->pointer])) {
			$where = ' where ';
			$prefix = call_user_func(array($this->link[$this->pointer][1][0], 'quickformPrefix'));
			if (isset($_REQUEST[$prefix . $this->link[$this->pointer][1][1]])) {
				$where .= $this->link[$this->pointer][0] . '=' . $_REQUEST[$prefix . $this->link[$this->pointer][1][1]];
			} else if (!isset($_REQUEST[call_user_func(array($this->pointer, 'quickformPrefix')) . 'id'])) {
				$prefix = call_user_func(array($this->pointer, 'quickformPrefix'));
				$where .= $this->link[$this->pointer][0] . '=' . $_REQUEST[$prefix . $this->link[$this->pointer][0]];
			} else {
				$prefix = call_user_func(array($this->pointer, 'quickformPrefix'));
				$n = new $this->pointer($_REQUEST[$prefix . 'id']);
				$where .= $this->link[$this->pointer][0] . '=' . $n->get($this->link[$this->pointer][0]);
			}
			
		}
		if (isset($this->filter[$this->pointer])) {
			if (!is_array($this->filter[$this->pointer])) {
				$where .= $this->filter[$this->pointer];
			}
		}
		
		
		if (isset($this->order[$this->pointer])) {
			$where .= ' order by ' . $this->order[$this->pointer];
		}
		
		$this->perPage = isset($_REQUEST['X-DataLimit']) ? $_REQUEST['X-DataLimit'] : $this->perPage;
		
			$sql = 'select count(id) as count from ' . (call_user_func(array($this->pointer, 'createTable'))->name()) . ' ' . $where;
			$r = Database::singleton()->query_fetch($sql);
			
			$currentPage = @$_REQUEST['pageID'];
			
			require_once('Pager/Pager.php');
			$pagerOptions = array(
			    'mode'     => 'Sliding',
			    'delta'    => 4,
			    'perPage'  => $this->perPage,
				'append'   => true,  //don't append the GET parameters to the url
		  	  	'fileName'     => '/admin/' . $_REQUEST['module'] . "&section=" . $this->pointer . "&pageID=%d",
		    	'path' => '/admin/Contacts',
				'totalItems' => $r['count']
			);
			$pager =& Pager::factory($pagerOptions);
			
			list($from, $to) = $pager->getOffsetByPageId();
			$where .= ' limit ' . ($from - 1) . ', ' . ($this->perPage);
		$items = call_user_func(array($this->pointer, 'getAll'), $where);

		switch ($type) {
		case 'html':
		default:
		if (isset($this->link[$this->pointer])) {
			$linked = $this->link[$this->pointer][1][0];
			$prefix = call_user_func(array($linked, 'quickformPrefix'));
			
			if ($id = @$_REQUEST[$prefix . $this->link[$this->pointer][1][1]]) {
				$ownprefix = call_user_func(array($this->pointer, 'quickformPrefix'));
				$add = "&amp;" . $ownprefix . $this->link[$this->pointer][0] . '=' . $id;
			} else if ($items[0]) {
				$ownprefix = call_user_func(array($this->pointer, 'quickformPrefix'));
				$add = "&amp;" . $ownprefix . $this->link[$this->pointer][0] . '=' . $items[0]->get($this->link[$this->pointer][0]);
			}
		}
		
		if (count($this->heading)) {
			$html .= '<div id="subnav">';
			foreach ($this->heading as $key => $head) {
				if ($this->user->hasPerm($key, 'view'))
				$html .= ' <a href="/admin/' . $_REQUEST['module'] . '&amp;section=' . $key . @$add . '">' . $head . '</a> | ';
			}
			$html = rtrim($html, ' |');
			$html .= '</div>';
		}
		
		if (isset($this->link[$this->pointer])) {
			$class = $this->link[$this->pointer][1][0];
			$prefix = call_user_func(array($class, 'quickformPrefix'));
			if (isset($_REQUEST[$prefix . 'id'])) {
				$r = $this->catchActions();
				$i = new $class($_REQUEST[$prefix . 'id']);
				$i->getAddEditForm('/admin/' . $_REQUEST['module']);
				$i->__construct($i->getId());
				$f = $i->getAddEditForm('/admin/' . $_REQUEST['module']);
				$html .= $f->display();
			}
		}
		if (!$this->user->hasPerm($this->pointer, 'view')) {
			return $html . $this->error('view');
		}
		
		if (isset($this->pre[$this->pointer]) || count($items) == 0) {
			$html .= '<div class="roundcont">

				   <div class="roundtop">
					 <img src="/images/admin/noAsset_tl.png" alt="" 
					 width="20" height="20" class="corner" 
					 style="display: none" />
				   </div>';
				
			
			if (count($items) == 0) {
				$html .= '<p>No ' . $this->getName() . 's Created.';
				if ($this->user->hasPerm($this->pointer, 'addedit')) {
					$html .= ' Would you like to <a href="/admin/' . $_REQUEST['module'] . '&amp;section=' . $this->pointer . '&amp;action=add' . @$add . '">make one</a>?</p>';
				}
			}
			if (count($items) == 0 && (isset($this->pre[$this->pointer]))) {
				$html .= "<br /><br />";
			}
			if (isset($this->pre[$this->pointer])) {
				$html .= '<div class="interior">' . @$this->pre[$this->pointer] . '</div>';
			}
			$html .= '<div class="roundbottom">
					 <img src="/images/admin/noAsset_bl.png" alt="" 
					 width="20" height="20" class="corner" 
					 style="display: none" />
				
				   </div>

				</div>';
			
			if (count($items) == 0) {
				return $html;
			}
		}
		
		if (isset($this->showcreate[$this->pointer]) && $this->showcreate[$this->pointer] && $this->user->hasPerm($this->pointer, 'addedit')) {
			$html .= '<br /><div id="header">
				<ul id="primary">
					<li><a href="/admin/' . $_REQUEST['module'] . '&amp;section=' . $this->pointer . '&amp;action=add' . @$add . '" title="Create ' . $this->getName() .'">Create ' . $this->getName() . '</a></li>
				</ul></div>';
			$html .= '<div style="float: left; width: 300px;">' . $pager->links . '</div>';
		} else {
			$html .= '<div style="float: left; width: 300px;">' . $pager->links . '</div>';
			$html .= '<br />';
		}	
		
		$html .= '<table border="0" cellspacing="0" cellpadding="0" class="adminList">';
		$html .= '<tbody>';
		$html .= '<tr>';
		foreach ($this->tables[$this->pointer] as $key => $name) {
			$html .= '<th valign="middle">' . $key . '</th>';
		}
		if ($this->user->hasPerm($this->pointer, 'addedit') || $this->user->hasPerm($this->pointer, 'delete')) $html .= '<th valign="middle">Actions</th>';
		$html .= '</tr>';
		
		foreach ($items as $key => $item) {
			$html .= '<tr class="';
			if ($key & 1) {
				$html .= 'row2';
			} else {
				$html .= 'row1';
			}
			$html .= '">';
			foreach ($this->tables[$this->pointer] as $key => $name) {
				$html .= '<td>';
				if (!is_array($name)) {
					$html .= $item->table()->column($name)->__toString($item,$name);
				} else {
					$tmp = new $name[1][0]($item->table()->column($name[0])->__toString($item,$name[0]));
					
					for ($i = 1; $i < count($name[1]); $i++) {
						$html .= call_user_func(array($tmp, $name[1][$i])) . ' ';
					}
				}
				$html .= '</td>';
			}
			if ($this->user->hasPerm($this->pointer, 'addedit') || $this->user->hasPerm($this->pointer, 'delete')) {
			$html .= '<td>';
			
			if ($this->user->hasPerm($this->pointer, 'addedit')) {
			
				$html .= '<form action="/admin/' . $_REQUEST['module'] . '" method="post" style="float: left;"';
				
				if (!isset($this->ajax['addedit']) || $this->ajax['addedit'] == true) {
					$html .= ' class="norexui_addedit"';
				}
				
				$html .= '>
						<input type="hidden" name="section" value="' . get_class($item) . '" />
						<input type="hidden" name="action" value="addedit" />
						<input type="hidden" name="' . $item->quickformPrefix() . 'id" value="' . $item->get('id') . '" />
						<input type="image" src="/images/admin/pencil.png" />
					</form>';
				
			}
			
			if ($this->user->hasPerm($this->pointer, 'delete')) {
				$html .= '<form action="/admin/' . $_REQUEST['module'] . '" class="norexui_delete" method="post" style="float: left;"';
				
				if (!isset($this->ajax['delete']) || $this->ajax['addedit'] == true) {
					//$html .= ' class="norexui_delete"';
				}
				
				$html .= '>
						<input type="hidden" name="section" value="' . get_class($item) . '" />
						<input type="hidden" name="action" value="delete" />
						<input type="hidden" name="' . $item->quickformPrefix() . 'id" value="' . $item->get('id') . '" />
						<input type="image" src="/images/admin/page_delete.png" />
					</form>';
			}
			$html .= '</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		
		$html .= '</table>';
		
		if (isset($this->post[$this->pointer])) {
			$html .= $this->post[$this->pointer];
		}
		return $html;
		break;
		
		case 'json':
			$tmp = array();
			foreach ($items as $item) {
				$tmp[] = $item->values();
			}
			
			header('Content-Type: text/javascript');
			echo json_encode($tmp);
			die();
		}
	}
	
}

?>