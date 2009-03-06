<?php
include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');
class Product extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'name', 'Title'),
			DBColumn::make('!select', 'supplier', 'Supplier',Module_EComm::getIndexes("ecomm_supplier","id","name",0)),
			DBColumn::make('!select', 'category', 'Category',Module_EComm::getIndexes("ecomm_category","id","name",0)),
			DBColumn::make('!select', 'producttype', 'Product Type',Module_EComm::getIndexes("ecomm_product_type","id","name",0)),
			DBColumn::make('!select', 'tax_class', 'Tax Class',Module_EComm::getIndexes("ecomm_tax_class","id","name",0)),
			DBColumn::make('!integer', 'stock_quantity', 'Stock Quantity'),
			DBColumn::make('//integer', 'image', 'Image'),
			DBColumn::make('!money', 'price', 'Price (' . SiteConfig::get("EComm::CurrencySign") . ")"),
			DBColumn::make('timestamp', 'date_added', 'Date Added'),
			DBColumn::make('//text', 'last_modified', 'Last Modified'),
			DBColumn::make('select', 'status', 'Status',array('1'=>'Active','0'=>'Inactive')),
			DBColumn::make('tinymce', 'details', 'Details')
		);
		return new DBTable("ecomm_product", __CLASS__, $cols);
	}
	
	public function getPrice(){//This function has to be overridden because we want to display only two numbers after the decimal
		return number_format($this->get("price"), 2);
	}
	
	public function getAddEditFormHook($form){
		$newImage = $form->addElement('file', $this->quickformPrefix() . "image_upload", 'Image');
		$form->addElement('checkbox', $this->quickformPrefix() . 'no_image', 'No image');
		if ($this->getImage()) {
			$curImage = $form->addElement('dbimage', $this->quickformPrefix() . 'image', $this->getImage() . "&w=400");
		}
		if ($this->getDateAdded())
			$form->addElement('static', $this->quickformPrefix() . 'date_added_label', 'Date Added', $this->getDateAdded()->getDate());
		if ($this->getLastModified())
			$form->addElement('static', $this->quickformPrefix() . 'last_modified_label', 'Last Modified', $this->getLastModified());
		
		$hookResults = ECommProduct::adminPluginHooks("BeforeDisplayForm", $this, $form);
		$form->addElement('button', 'btn_cancel','Cancel',array("onclick"=>"document.location='/admin/EComm&section=" . $_REQUEST["section"] . "';"));
	}

	public function getAddEditFormSaveHook($form){
		if (@$_REQUEST[$this->quickformPrefix() . "no_image"]){
			$this->setImage(0);
		}
		else{
			$newImage = $form->addElement('file', $this->quickformPrefix() . "image_upload", 'Image');
			if ($newImage->isUploadedFile()) {
				$im =new Image();
				$id = $im->insert($newImage->getValue());
				$this->setImage($id);
			}
		}
		$this->setLastModified(date('Y-m-d G:i:s'));
		
		$hookResults = ECommProduct::adminPluginHooks("BeforeSave", $this, $form);
	}
	
	public static function getAll($filter = true, $from = null, $limit = null){
		$sql = 'select `id` from ecomm_product';
		if ($filter)
			$sql .= ' where status = 1';
		if ($from && $limit)
			$sql .= " limit $from, $limit";
		
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = Product::make($result['id'],'Product');
		}
		
		return $results;
	}
	
	public static function searchProducts($params, $filter=true){//This function returns the products that belong to a category, product type, and/or supplier
		$sql  = 'select `id` from ecomm_product where 1=1';
		
		if ($filter)
			$sql .= " and status=1";
		
		if (@$params["Name"])
			$sql .= ' and (name like "%' . e($params["Name"]) . '%" OR details like "%' . e($params["Name"]) . '%")';
		if (@$params["Category"])
			$sql .= ' and category="' . e($params["Category"]) . '"';
		if (@$params["Supplier"])
			$sql .= ' and supplier="' . e($params["Supplier"]) . '"';
		if (@$params["ProductType"])
			$sql .= ' and producttype="' . e($params["ProductType"]) . '"';
		
		if (@$params["Price1"] && @$params["PriceOp"]){
			if ($params["PriceOp"] == "less")
				$sql .= ' and price <= "' . e($params["Price1"]) . '"';
			elseif ($params["PriceOp"] == "greater")
				$sql .= ' and price >= "' . e($params["Price1"]) . '"';
			elseif ($params["PriceOp"] == "between")
				$sql .= ' and price >= "' . e($params["Price1"]) . '" and price <= "' . e($params["Price2"]) . '"';
		}
		$sql .= ' order by ecomm_product.name';
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as &$result) {
			$result = Product::make($result['id'],'Product');
		}
		
		return $results;
	}
	
	public static function searchProductsSimple($searchPhrase){
		$sql  = 'select ecomm_product.id from ecomm_product
					left join ecomm_category on ecomm_product.category = ecomm_category.id
					left join ecomm_supplier on ecomm_product.supplier = ecomm_supplier.id
					left join ecomm_product_type on ecomm_product.producttype = ecomm_product_type.id
					where ecomm_product.status=1 and (';
		$sql .= ' ecomm_product.name like "%' . e($searchPhrase) . '%" OR ecomm_product.details like "%' . e($searchPhrase) . '%"';
		$sql .= ' OR ecomm_category.name like "%' . e($searchPhrase) . '%"';
		$sql .= ' OR ecomm_supplier.name like "%' . e($searchPhrase) . '%"';
		$sql .= ' OR ecomm_product_type.name like "%' . e($searchPhrase) . '%"';
		$sql .= ')';
		$sql .= ' order by ecomm_product.name';
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as &$result) {
			$result = Product($result['id'],'Product');
		}
		
		return $results;
	}
	
	static function getQuickFormPrefix() {return 'product_';}
}
DBRow::init('Product');
