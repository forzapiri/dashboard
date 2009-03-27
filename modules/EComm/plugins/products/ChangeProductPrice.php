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