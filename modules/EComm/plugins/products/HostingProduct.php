<?php
class HostingProduct extends ECommProduct implements ECommProduct_interface {
	public function __construct(){
		$this->pluginName = "Hosting Product";
		$this->pluginDetails = "Sets up hosting specs for an EComm product";
	}
	
	public function adminHookBeforeDisplayForm(&$product, &$form){
		$items = HostingItem::getAll($product->getId());

		if($items && count($items) > 0){
			$defaultValues['specs'] = $items[0]->get('specs');
			$form->setDefaults($defaultValues);
		}
		
		$form->addElement('textarea', 'specs', 'Product Specs<br /> (one per line)', array("style" => "width: 300px; height: 200px;"));
	}
	
	public function adminHookBeforeSave(&$product, &$form){}
	
	public function adminHookAfterSave(&$product, &$form){
		$items = HostingItem::getAll($product->get('id'));
		
		if(count($items) > 0){
			foreach($items as $item){
				$item->set('specs', $form->exportValue('specs'));
				$item->save();
			}
		} else {
			$obj = DBRow::make(null, 'HostingItem');
			$obj->set('parent_id', $product->get('id'));
			$obj->set('specs', $form->exportValue('specs'));
			$obj->save();
		}
	}
	
	public function adminHookBeforeDelete(&$product){}
	public function adminHookAfterDelete(&$product){}
	
	public function clientHookBeforeDisplayProduct(&$product, &$ecommModule){
		$session = Session::getActiveSession();
		$allItems = CartItem::getAll($session->getId());
		foreach($allItems as $item){
			$item->delete();
		}
		$cartItem = CartItem::make(null,'CartItem');
		$cartItem->setSession($session->getId());
		$cartItem->setProduct($product->getId());
		$cartItem->setQuantity(@$_REQUEST["quantity"]);
		$cartItem->setTransaction(0);
		$_POST['address_street_address'] = 'N/A';
		$_POST['address_city'] = 'N/A';
		$_POST['address_post_code'] = 'N/A';
		$_POST['address_state'] = '7';
		$_POST['address_country'] = '31';
		$cartItem->save();
		$auth_container = new CMSAuthContainer();
		$auth = new Auth($auth_container, null, 'authHTML');
		if($auth->checkAuth()){
			header("Location: /Store/Cart&action=Checkout");
			exit;
		} else {
			header( 'Location: /Store/Cart/&action=Display&loginFail=1' );//Invalid username or password
			exit;
		}
	}
	public function clientHookBeforeAddToCart(&$product, &$ecommModule){}
	public function clientHookAfterAddToCart(&$cartItem, &$ecommModule){}
	public function clientHookBeforeDisplayCartItem(&$cartItem, &$ecommModule){
	}
	public function calculatePrice(&$cartItem){}
}

include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');
class HostingItem extends DBRow {
	function createTable(){
		$cols = array(
			"id?",
			DBColumn::make('!integer', 'parent_id'),
			DBColumn::make('text', 'specs', 'Product Specs')
		);
		return new DBTable("ecomm_product_hosting", __CLASS__, $cols);
	}

	public static function getAll($productId){
		if(!$productId)
			return false;
		
		$sql = 'SELECT id FROM ecomm_product_hosting WHERE parent_id='.e($productId);
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach($results as &$result)
			$result = DBRow::make($result['id'], 'HostingItem');
			
		return $results;
	}
	
	public function getSpecList(){
		$specs = $this->get('specs');
		return(explode('\n', $specs));
	}
	
	static function getQuickFormPrefix() {return 'hostingproduct_';}
}

DBRow::init('HostingItem');
?>