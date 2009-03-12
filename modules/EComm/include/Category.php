<?php
include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');

class Category extends DBRow {
	function createTable() {
		$allCats = Module_EComm::getIndexes("ecomm_category","id","name",0);
		$parentDropDown = array("0" => "- Top Level -");
		foreach ($allCats as $key=>$val)
			$parentDropDown[$key] = $val;
		$cols = array(
			'id?',
			DBColumn::make('!text', 'name', 'Name'),
			DBColumn::make('!select', 'parent_category', 'Parent Category', $parentDropDown),
			DBColumn::make('//integer', 'image', 'Image'),
			DBColumn::make('timestamp', 'date_added', 'Date Added'),
			DBColumn::make('//text', 'last_modified', 'Last Modified'),
			DBColumn::make('select', 'status', 'Status',array('1'=>'Active','0'=>'Inactive')),
			DBColumn::make('tinymce', 'details', 'Details')
		);
		return new DBTable("ecomm_category", __CLASS__, $cols);
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
	
	public static function getAll($filter = true, $parentCategory = null){
		$sql = 'select `id` from ecomm_category where 1=1';
		if ($filter)
			$sql .= ' and status = 1';
		if (is_numeric($parentCategory))
			$sql .= " and parent_category = '" . e($parentCategory) . "'";
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'Category');
		}
		
		return $results;
	}
	
	public function displayBreadCrumb(){
		//TODO: display the current category as plain text instead of a link (a simple default parameter can do it)
		$result = '';
		if (!$this->getId())
			return '<a href="' . Module_EComm::getModulePrefix() . 'Category">Back to categories</a>';
		$parent = DBRow::make($this->getParentCategory(), 'Category');
		return $parent->displayBreadCrumb() . ' | <a href="' . Module_EComm::getModulePrefix() . 'Category/' . $this->getId() . '">' . $this->getName() . '</a>';
	}
	
	static function getQuickFormPrefix() {return 'category_';}
}
DBRow::init('Category');
?>