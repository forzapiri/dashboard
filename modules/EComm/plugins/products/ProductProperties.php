<?php
class ProductProperties extends ECommProduct{
	private $productProperty;
	public function __construct(){
		$this->pluginName = "Product Properties";
		$this->pluginDetails = "Any non-standard property goes here: Pallet count, weight, and weight unit";
	}
	
	public function getProductProperty($product){
		if (!$this->productProperty || $this->productProperty->getProduct() != $product->getId())
			$this->productProperty = ProductPropertiesTbl::getPropertiesBasedOnProductId($product->getId());
		return $this->productProperty;
	}
	
	public function adminHookBeforeDisplayForm(&$product, &$form){
		$productProperty = $this->getProductProperty($product);
		
		$palletCount = $form->createElement('text', 'product_pallet_count', "Pallet Count");
		$weight = $form->createElement('text', 'product_weight', "Weight");
		$weightUnit = $form->createElement('select', 'product_weight_unit', "Weight Unit",array('KG'=>'KG','Cubic Feet'=>'Cubic Feet','Cubic Yards'=>'Cubic Yards','LB'=>'LB'));
		$productCode = $form->createElement('text', 'product_product_code', "Product Code");
		
		$form->insertElementBefore($palletCount, "product_details");
		$form->insertElementBefore($weight, "product_details");
		$form->insertElementBefore($weightUnit, "product_details");
		$form->insertElementBefore($productCode, "product_name");
		
		$defaultValue = array();
		$defaultValue["product_pallet_count"] = $productProperty->getPalletCount();
		$defaultValue["product_weight"] = $productProperty->getWeight();
		$defaultValue["product_weight_unit"] = $productProperty->getWeightUnit();
		$defaultValue["product_product_code"] = $productProperty->getProductCode();
		$form->setDefaults($defaultValue);
		
		$form->addRule('product_pallet_count', "Pallet count cannot be empty", 'required', null, 'client');
		$form->addRule('product_weight', "Weight cannot be empty", 'required', null, 'client');
		$form->addRule('product_weight_unit', "Weight unit cannot be empty", 'required', null, 'client');
	}
	
	public function adminHookAfterSave(&$product, &$form){
		$productProperty = $this->getProductProperty($product);
		
		$productProperty->setProduct($product->getId());
		$productProperty->setPalletCount($_REQUEST["product_pallet_count"]);
		$productProperty->setWeight($_REQUEST["product_weight"]);
		$productProperty->setWeightUnit($_REQUEST["product_weight_unit"]);
		$productProperty->save();
	}
	
	public function clientHookBeforeDisplayProduct(&$product, &$ecommModule){
		$productProperty = $this->getProductProperty($product);
		$html = '<b>Weight: </b>' . $productProperty->getWeight() . ' ' . $productProperty->getWeightUnit() . '<br style="clear:both;"/><br/>';
		return array('HTML' => $html);
	}
	
	public function clientHookBeforeDisplayCartItem(&$cartItem, &$ecommModule){
		$product = $cartItem->getCartItemProduct();
		$productProperty = $this->getProductProperty($product);
		$html = '<b>Weight: </b>' . $productProperty->getWeight() . ' ' . $productProperty->getWeightUnit() . '<br style="clear:both;"/><br/>';
		return array('HTML' => $html);
	}

	public function getProperty($propertyName, $product){
		$productProperty = $this->getProductProperty($product);
		return call_user_func(array($productProperty, "get" . $propertyName));
	}
}

include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');
class ProductPropertiesTbl extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!integer', 'product', 'Product'),
			DBColumn::make('!integer', 'pallet_count', 'Pallet Count'),
			DBColumn::make('!float', 'weight', 'Weight'),
			DBColumn::make('!select', 'weight_unit', 'Weight Unit', array('KG'=>'KG','Cubic Feet'=>'Cubic Feet','Cubic Yards'=>'Cubic Yards','LB'=>'LB')),
			DBColumn::make('text', 'product_code', 'Product Code'),
		);
		return new DBTable("ecomm_product_properties", __CLASS__, $cols);
	}
	
	public static function getPropertiesBasedOnProductId($productId){
		if (!$productId)
			return DBRow::make('', 'ProductPropertiesTbl');
		$sql = 'select `id` from ecomm_product_properties where product = "' . e($productId) . '"';
		$result = Database::singleton()->query_fetch($sql);
		return DBRow::make($result['id'], 'ProductPropertiesTbl');
	}
	
	static function getQuickFormPrefix() {return 'product_';}
}
DBRow::init('ProductPropertiesTbl');
?>