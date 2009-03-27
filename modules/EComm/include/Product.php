<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

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
			DBColumn::make('!float', 'price', 'Price (' . SiteConfig::get("EComm::CurrencySign") . ")"),
			DBColumn::make('timestamp', 'date_added', 'Date Added'),
			DBColumn::make('//text', 'last_modified', 'Last Modified'),
			DBColumn::make('select', 'status', 'Status',array('1'=>'Active','0'=>'Inactive')),
			DBColumn::make('tinymce', 'details', 'Details')
		);
		return new DBTable("ecomm_product", __CLASS__, $cols);
	}
	
	public function getAddEditFormHook($form){
		//The following four hidden variable are necessary so we can go to the page and the filters the user was viewing before editing this product
		if (@$_REQUEST["pageID"]){
			$form->setConstants( array ( 'pageID' => $_REQUEST["pageID"]));
			$form->addElement( 'hidden', 'pageID' );
		}
		if (@$_REQUEST["Supplier"]){
			$form->setConstants( array ( 'Supplier' => $_REQUEST["Supplier"]));
			$form->addElement( 'hidden', 'Supplier' );
		}
		if (@$_REQUEST["Category"]){
			$form->setConstants( array ( 'Category' => $_REQUEST["Category"]));
			$form->addElement( 'hidden', 'Category' );
		}
		if (@$_REQUEST["ProductType"]){
			$form->setConstants( array ( 'ProductType' => $_REQUEST["ProductType"]));
			$form->addElement( 'hidden', 'ProductType' );
		}
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
				$im = new Image();
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
			$result = DBRow::make($result['id'], 'Product');
		}
		
		return $results;
	}
	
	public static function searchProducts($params, $filter=true, $from = null, $limit = null){//This function returns the products that belong to a category, product type, and/or supplier
		$sql  = 'select `id` from ecomm_product where 1=1';
		if (isset($params["onlyCount"]))
			$sql  = 'select count(*) as product_cnt from ecomm_product where 1=1';
		
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
		if (isset($params["onlyCount"])){
			$results = Database::singleton()->query_fetch($sql);
			return $results["product_cnt"];
		}
		
		$sql .= ' order by ecomm_product.name';
		if ($from && $limit)
			$sql .= " limit $from, $limit";
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'Product');
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
			$result = DBRow::make($result['id'], 'Product');
		}
		
		return $results;
	}
	
	/*
	 * The following function is meant to be used for displaying some of the plugin data in tables, if necessary
	 * However, if you can do whatever you want to do using plugins, it is better not to use this method
	 */
	public function getPluginProperty($pluginName, $propertyName){
		require_once SITE_ROOT . '/modules/EComm/plugins/products/ECommProduct.php';
		$ECommPlugins = new ECommProduct();
		return $ECommPlugins->getPluginProperty($pluginName, $propertyName, $this);
	}
	
	static function getQuickFormPrefix() {return 'product_';}
}
DBRow::init('Product');
?>