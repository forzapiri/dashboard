<?php
class defaultPageActs {
	
	public function initDefaultActs(){
		$this->pageActions = array();
		$this->pageActions['add']['perm'] = 'addedit';
		$this->pageActions['add']['icon'] = '';
		$this->pageActions['add']['callback'] = 'addedit';
		$this->pageActions['add']['restrict'] = array();
		$this->pageActions['add']['show'] = false;
		
		$this->pageActions['addedit']['perm'] = 'addedit';
		$this->pageActions['addedit']['icon'] = '/images/admin/pencil.png';
		$this->pageActions['addedit']['callback'] = 'addedit';
		$this->pageActions['addedit']['restrict'] = array();
		$this->pageActions['addedit']['show'] = true;
		
		$this->pageActions['delete']['perm'] = 'delete';
		$this->pageActions['delete']['icon'] = '/images/admin/cross.png';
		$this->pageActions['delete']['callback'] = 'delete';
		$this->pageActions['delete']['restrict'] = array();
		$this->pageActions['delete']['show'] = true;
		
		$this->pageActions['toggle']['perm'] = 'addedit';
		$this->pageActions['toggle']['icon'] = '';
		$this->pageActions['toggle']['callback'] = 'toggle';
		$this->pageActions['toggle']['restrict'] = array();
		$this->pageActions['toggle']['show'] = false;
	}
	
	public function default_addedit(&$i, $idField){
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
	}
	
	public function default_toggle(&$i){
		if ($this->user->hasPerm($this->pointer, $this->pageActions[$_REQUEST['action']]['perm'])) $i->toggle();
	}
	
	public function default_delete(&$i){
		if ($this->user->hasPerm($this->pointer, $this->pageActions[$_REQUEST['action']]['perm'])) $i->delete();
	}
}
?>