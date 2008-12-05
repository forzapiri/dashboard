<?php
/**
 * Blocks
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * DETAILED CLASS TITLE
 *
 * DETAILED DESCRIPTION OF THE CLASS
 * @package CMS
 * @subpackage Core
 */

class ContentPageRevision extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('integer?', 'parent', 'Parent'),
			DBColumn::make('text', 'page_title', 'Page Title'),
			DBColumn::make('tinymce', 'content', 'Page Content'),
			DBColumn::make('select', 'page_template', 'Page Template', Template::toArray('CMS')),
			'timestamp',
			'status',
			
			);
		return new DBTable("content_page_data", __CLASS__, $cols);
	}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
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
	
	public function getAddEditForm($target = null) {
		$this->set('timestamp', null);
		if (isset($_REQUEST[$this->quickformPrefix() . 'parent'])) {
			$this->set('parent', $_REQUEST[$this->quickformPrefix() . 'parent']);
		}
		$form = parent::getAddEditForm($target);
		$el =& $form->removeElement($this->quickformPrefix() . 'id');
		if($form->isProcessed() && $form->exportValue($this->quickformPrefix() . 'status') == 1){
			ContentPageRevision::disableOthers($this);
		}
		return $form;
	}

}
DBRow::init('ContentPageRevision');
?>