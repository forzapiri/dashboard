<?php
class ContentPageRevision extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('integer?', 'parent', 'Parent'),
			DBColumn::make('text', 'page_title', 'Page Title'),
			DBColumn::make('tinymce', 'content', 'Page Content'),
			'timestamp',
			'status',
			);
		return new DBTable("content_page_data", __CLASS__, $cols);
	}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}
	function quickformPrefix() {return 'content_page_data_';}

	public static function disableOthers(&$n) {
		fb('disable');
		if(@!$o = $n->getNotificationObject()){
			$o = $n;
		}
		$rs = self::getAll('where parent=' . $o->getParent() . ' and status=1');
		foreach ($rs as $r) {
			if ($r->getId() != $o->getId()) {
				$r->setStatus(false)->save();
			}
		}
	}
	public function getSubContent() {return getSubContentFor($this->getId());}
	public function getAddEditFormSaveHook($form) {
		if (1 == $form->exportValue($this->quickformPrefix() . 'status')){
			ContentPageRevision::disableOthers($this);
		}
	}

	public function getAddEditForm($target = null) {
		$this->set('timestamp', null);
		if (isset($_REQUEST[$this->quickformPrefix() . 'parent'])) {
			$this->set('parent', $_REQUEST[$this->quickformPrefix() . 'parent']);
		}
		$form = parent::getAddEditForm($target);
		$el =& $form->removeElement($this->quickformPrefix() . 'id');
		return $form;
	}
}
DBRow::init('ContentPageRevision');
?>
