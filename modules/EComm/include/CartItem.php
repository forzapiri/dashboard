<?php
include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');

class CartItem extends DBRow {
	private $cartItemProduct=null;
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('integer', 'session', 'Session ID'),
			DBColumn::make('integer', 'product', 'Product'),
			DBColumn::make('integer', 'quantity', 'Quantity'),
			DBColumn::make('integer', 'transaction', 'Transaction')
		);
		return new DBTable("ecomm_cart_item", __CLASS__, $cols);
	}
	
	public static function getAll($sessionId=0){
		$sql = 'select `id` from ecomm_cart_item';
		if ($sessionId)
			$sql .= " where session = '" . e($sessionId) . "'";
		$sql .= " order by id";
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = CartItem::make($result['id'],'CartItem');
		}
		return $results;
	}
	
	public function getCartItemProduct(){//Return the object of the product
		$productId = $this->getProduct();
		if ($this->cartItemProduct && $this->cartItemProduct->getId() == $productId)
			return $this->cartItemProduct;
		$this->cartItemProduct = Product::make($productId,'Product');
		return $this->cartItemProduct;
	}
	
	public function calculatePrice(){
		//This method calls the getPrice method (which returns the base price) and then adds all the plugin prices
		//This method calcultes the price of the product plus the added price of the plugins
		require_once SITE_ROOT . '/modules/EComm/plugins/products/ECommProduct.php';
		$plugInPrices = ECommProduct::getPluginsPrice($this);
		return $plugInPrices + $this->getCartItemProduct()->getPrice();
	}
	
	static function getQuickFormPrefix() {return 'cartitem_';}
}
DBRow::init('CartItem');
