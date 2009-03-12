<?php
class ChangeProductPrice extends ECommProduct{
	public function __construct(){
		$this->pluginName = "Change products' prices";
		$this->pluginDetails = "An easy way to change the prices of all the products in one page";
	}
	
	public function hasAdminInterface(){
		return true;
	}	

	public function getAdminInterface(){
		$st = "select ecomm_product.id as product_id, ecomm_product.name as product_name,
				ecomm_product.supplier as supplier_id, ecomm_supplier.name as supplier_name, ecomm_product.price as product_price
				from ecomm_product left join ecomm_supplier on ecomm_product.supplier = ecomm_supplier.id
				order by ecomm_supplier.name,ecomm_product.name";
		$products = Database::singleton()->query_fetch_all($st);
		
		$formPath = "/admin/EComm&section=Plugins&page=ChangeProductPrice";
		$form = new Form('change_product_prices', 'post', $formPath);
		if ($form->validate() && isset($_REQUEST['submit'])){
			foreach ($products as $product) {
				$ECommProduct = DBRow::make($product['product_id'], 'Product');
				$ECommProduct->setPrice($_REQUEST['product_' . $product['product_id']]);
				$ECommProduct->save();
			}
			return "Your products' prices have been changed successfully<br/><a href='$formPath'>Go back</a>";
		}
		$oldSupplier = 0;
		$currentSupplier = 0;
		$defaultValue = array();
		foreach ($products as $product) {
			$currentSupplier = $product['supplier_id'];
			if ($oldSupplier != $currentSupplier)
				$form->addElement('html', '<br/><br/><hr/><h3>Supplier: ' . $product['supplier_name'] . '</h3>');
			
			$form->addElement('text', 'product_' . $product['product_id'], $product['product_name']);
			$defaultValue['product_' . $product['product_id']] = $product['product_price'];
			$oldSupplier = $product['supplier_id'];
		}
		$form->addElement('submit', 'submit', 'Submit');
		$form->setDefaults($defaultValue);
		return $form->display();
	}	
}
?>