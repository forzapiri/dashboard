<?php
class defaultPageActs {
	
	public function initDefaultActs(){
		if(!array_key_exists($this->pointer, $this->pageActions)) $this->pageActions[$this->pointer] = array();
		if(!array_key_exists('add', $this->pageActions[$this->pointer])){
			$this->pageActions[$this->pointer]['add']['perm'] = 'addedit';
			$this->pageActions[$this->pointer]['add']['class'] = 'addedit';
			$this->pageActions[$this->pointer]['add']['icon'] = '';
			$this->pageActions[$this->pointer]['add']['callback'] = 'addedit';
			$this->pageActions[$this->pointer]['add']['restrict'] = array();
			$this->pageActions[$this->pointer]['add']['show'] = false;
		}
		
		if(!array_key_exists('addedit', $this->pageActions[$this->pointer])){
			$this->pageActions[$this->pointer]['addedit']['perm'] = 'addedit';
			$this->pageActions[$this->pointer]['addedit']['class'] = 'addedit';
			$this->pageActions[$this->pointer]['addedit']['icon'] = '/images/admin/pencil.png';
			$this->pageActions[$this->pointer]['addedit']['callback'] = 'addedit';
			$this->pageActions[$this->pointer]['addedit']['restrict'] = array();
			$this->pageActions[$this->pointer]['addedit']['show'] = true;
		}
		
		if(!array_key_exists('delete', $this->pageActions[$this->pointer])){
			$this->pageActions[$this->pointer]['delete']['perm'] = 'delete';
			$this->pageActions[$this->pointer]['delete']['class'] = 'delete';
			$this->pageActions[$this->pointer]['delete']['icon'] = '/images/admin/cross.png';
			$this->pageActions[$this->pointer]['delete']['callback'] = 'delete';
			$this->pageActions[$this->pointer]['delete']['restrict'] = array();
			$this->pageActions[$this->pointer]['delete']['show'] = true;
		}
	
		if(!array_key_exists('toggle', $this->pageActions[$this->pointer])){
			$this->pageActions[$this->pointer]['toggle']['perm'] = 'addedit';
			$this->pageActions[$this->pointer]['toggle']['class'] = '';
			$this->pageActions[$this->pointer]['toggle']['icon'] = '';
			$this->pageActions[$this->pointer]['toggle']['callback'] = 'toggle';
			$this->pageActions[$this->pointer]['toggle']['restrict'] = array();
			$this->pageActions[$this->pointer]['toggle']['show'] = false;
		}
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
		if ($this->user->hasPerm($this->pointer, $this->pageActions[$this->pointer][$_REQUEST['action']]['perm'])) $i->toggle();
	}
	
	public function default_delete(&$i){
		if ($this->user->hasPerm($this->pointer, $this->pageActions[$this->pointer][$_REQUEST['action']]['perm'])) $i->delete();
	}
}
?>