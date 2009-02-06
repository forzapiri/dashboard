<?php

class Module_Content extends Module implements linkable {
	public function __construct() {
		parent::__construct();
		$dispatcher = &Event_Dispatcher::getInstance('ContentPage');
		$dispatcher->addNestedDispatcher(Event_Dispatcher::getInstance());
		
		$dispatcher->addObserver(array('ContentPage', 'checkForHome'), 'onPreDelete');
	}
	
	function getUserInterface() {
		$pageid = @$_REQUEST['id'];
		if ($pageid) { // Admin preview of a page
			if (!$this->user->hasPerm('ContentPage', 'addedit')) {
				return $this->smarty->dispErr('404', &$this);
			}
			$status = $_REQUEST['status'];
			$page = ContentPage::make($pageid);
		} else {
			$status = 'active';
			$pageid = ContentPage::keytoid($_REQUEST['page']);
			$pageid = $pageid['id'];
			$page = ContentPage::make($pageid);
			if (!$page->getStatus()) {
				return $this->smarty->dispErr('404', &$this);
			}
		}
		$this->smarty->assign('content',$page);
		$this->parentSmarty->templateOverride = $page->getSmartyResource();
		$this->setPageTitle("PAGE TITLE STUB");
		/* CHUNKS */
		$this->smarty->assign ('chunks', Chunk::getAllContentFor($page, $status));
		return $this->smarty->fetch('db:content.tpl');
	}
	
	function getAdminInterface() {
		var_dump ($_REQUEST);
		$id = @$_REQUEST['id'];
		if ($id) $page = ContentPage::make($id);
		switch (@$_REQUEST['action']) {
		case 'revertdrafts':
			Chunk::revertDrafts($page);
			break;
		case 'makeactive':
			Chunk::makeDraftActive($page);
			break;
		case 'loadChunk':
			// CHUNKS: Response to AJAX request only.
			$role = e(@$_REQUEST['role']);
			$name = e(@$_REQUEST['name']);
			$parent_class = e(@$_REQUEST['parent_class']);
			$parent = (int) @$_REQUEST['parent'];
			$sort = (int) @$_REQUEST['sort'];
			if ($role && $name) echo ChunkRevision::getNamedChunkFormField($role, $name);
			else if ($parent_class && $parent) echo ChunkRevision::getChunkFormField ($parent_class, $parent, $sort);
			else {
				trigger_error ('Bad AJAX request for loadChunk');
				var_log ($_REQUEST);
			}
			die();
		default: // Fall through
		}
		$this->addJS('/modules/Content/js/admin/handleHome.js');
		$this->addJS('/modules/Content/js/admin/chunk.js');
		$page = new Page();
		$page->with('ContentPage')
			->show(array('Name' => 'name',
						 'Created' => 'timestamp',
						 'Published' => 'status',
						 'Draft' => array('id', array('ContentPage', 'getDraftForms'))))
			->name('Content Page')
			->pre($this->smarty->fetch('admin/pages.tpl'));
		return $page->render();
	}
	
	public static function getLinkables($level = 0, $id = null){
		switch($level){
			case 1:
			default:
				$linkItems = ContentPage::getAll("where status = '1'");
				foreach($linkItems as $linkItem){
					$linkables[$linkItem->get('id')] = $linkItem->get('name');
				}
				return $linkables;
		}
	}
	
	public function getLinkable($id){
		$page = ContentPage::make($id);
		return '/content/' . $page->get('url_key');
	}
}

?>
