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

	function __construct($id = null) {
		/* CHUNKS:  Move this code to DBRow() with a check for $this->chunkable() ?? */
		$this->chunkManager = new ChunkManager($this);
		parent::__construct($id);
	}
	
	public function getAddEditFormSaveHook($form) {
		if (1 == $form->exportValue($this->quickformPrefix() . 'status')){
			ContentPageRevision::disableOthers($this);
		}
		/* CHUNKS:  Move this code to DBRow() with a check for $this->chunkable() ?? */
		$this->chunkManager->saveFormFields($form, $this);
	}

	public function getAddEditFormHook($form) {
		/* CHUNKS:  Move this code to DBRow() with a check for $this->chunkable() ?? */
		$page = ContentPage::make($this->getParent());
		$name = $page->getPageTemplate();
		$template = Template::getRevision('CMS', $name);
		$this->chunkManager->setTemplate($template);
		$this->chunkManager->insertFormFields($form);
	}

	public function getAddEditForm($target = null) {
		$this->set('timestamp', null);
		if (isset($_REQUEST[$this->quickformPrefix() . 'parent'])) {
			$this->set('parent', $_REQUEST[$this->quickformPrefix() . 'parent']);
		}
		$form = parent::getAddEditForm($target);
		// CHUNK:  DISABLE NOTION OF REVISION HISTORY
		// $el =& $form->removeElement($this->quickformPrefix() . 'id');
		return $form;
	}
}
DBRow::init('ContentPageRevision');
?>
