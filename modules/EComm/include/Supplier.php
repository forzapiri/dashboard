<?php
include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');

class Supplier extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'name', 'Name'),
			DBColumn::make('//integer', 'image', 'Image'),
			DBColumn::make('timestamp', 'date_added', 'Date Added'),
			DBColumn::make('//text', 'last_modified', 'Last Modified'),
			DBColumn::make('select', 'status', 'Status',array('1'=>'Active','0'=>'Inactive')),
			DBColumn::make('tinymce', 'details', 'Details')
		);
		return new DBTable("ecomm_supplier", __CLASS__, $cols);
	}
	
	public function getAddEditFormSaveHook($form){
		if (@$_REQUEST[$this->quickformPrefix() . "no_image"]){
			$this->setImage(0);
		}
		else{
			$newImage = $form->addElement('file', $this->quickformPrefix() . "image_upload", 'Image');
			if ($newImage->isUploadedFile()) {
				$im = new Image();
				$id = $im->insert($newImage->getValue());
				$this->setImage($id);
			}
		}
		$this->setLastModified(date('Y-m-d G:i:s'));
	}
	
	public function getAddEditFormHook($form){
		$newImage = $form->addElement('file', $this->quickformPrefix() . "image_upload", 'Image');
		$form->addElement('checkbox', $this->quickformPrefix() . 'no_image', 'No image');
		if ($this->getImage()) {
			$curImage = $form->addElement('dbimage', $this->quickformPrefix() . 'image', $this->getImage());
		}
		if ($this->getDateAdded())
			$form->addElement('static', $this->quickformPrefix() . 'date_added_label', 'Date Added', $this->getDateAdded()->getDate());
		if ($this->getLastModified())
			$form->addElement('static', $this->quickformPrefix() . 'last_modified_label', 'Last Modified', $this->getLastModified());
		$form->addElement('button', 'btn_cancel','Cancel',array("onclick"=>"document.location='/admin/EComm&section=" . $_REQUEST["section"] . "';"));
	}
	
	public static function getAll($filter = true){
		$sql = 'select `id` from ecomm_supplier';
		if ($filter)
			$sql .= ' where status = 1';
		
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = Supplier::make($result['id'],'Supplier');
		}
		
		return $results;
	}
	static function getQuickFormPrefix() {return 'supplier_';}
}
DBRow::init('Supplier');
?>