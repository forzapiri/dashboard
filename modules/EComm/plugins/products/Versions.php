<?php
class Versions extends ECommProduct implements ECommProduct_interface {
	public function __construct(){
		$this->pluginName = "Product Version";
		$this->pluginDetails = "Displays the Version number and what's new in each version";
	}
	
	public function adminHookBeforeDisplayForm(&$product, &$form){
		$versions = Version::getAll($product->getId());
		if($versions){
			foreach ($versions as $version) {
				$version_number = $form->createElement('text', 'product_version', 'Version #');
					$form->insertElementBefore($version_number, 'image_upload');
				$version_history = $form->createElement('tinymce', 'product_version_history', 'Version History');
					$form->insertElementBefore($version_history, 'image_upload');
				
				$defaultValues ['product_version'] = $version->getVersion();
				$defaultValues ['product_version_history'] = $version->getHistory();
				$form->setDefaults($defaultValues);
			}
		}else{
			$form->addElement('text', 'product_version', 'Version');
			$form->addElement('tinymce', 'product_version_history', 'History');
		}
	}
	
	public function adminHookAfterSave(&$product, &$form){
		if (!$product->getId())
			return "";
		$versions = Version::getAll($product->getId());
		if(count($versions)==0) {$obj = Version::make(null,'Version');}
		else {$obj = Version::make($versions[0]->getId(),'Version');}
		//$obj = Version::make($versions[0]->getId(),'Version');
		$obj->setProduct($product->getId());
		$obj->setVersion(@$_REQUEST['product_version']);
		$obj->setHistory(@$_REQUEST['product_version_history']);
		$obj->save();
	}
	
	public function adminHookBeforedelete(&$product){
		//return (array('abort'=> '1', 'msg' => "You cannot delete products"));
	}
	
	public function clientHookBeforeDisplay(&$product, &$ecommModule){
	    $versions = Version::getAll($product->getId());
		$ecommModule->smarty->assign('versions', $versions);
		//$ecommModule->smarty->assign('product', $product);
		$html = $ecommModule->smarty->fetch(SITE_ROOT . '/modules/EComm/plugins/products/templates/Versions.tpl');
		return (array(
					//'abort'=> '1', 
					//'msg' => 'hi there',
					'HTML' => $html 
				));
	}

	public function clientHookAfterAddToCart(&$cartItem, &$ecommModule){
		//Do whatever you want on the newly added item ($cartItem)
	}
	
	public function clientHookBeforeDisplayCartItem(&$cartItem, &$ecommModule){
		$product = $cartItem->getCartItemProduct();
		$versions = Version::getAll($product->getId());
		$ecommModule->smarty->assign('versions', $versions);
		$ecommModule->smarty->assign('product', $product);
		$html = $ecommModule->smarty->fetch(SITE_ROOT . '/modules/EComm/plugins/products/templates/Versions.tpl');
		return (array(
					//'abort'=> '1', 
					//'msg' => 'hi there',
					'HTML' => $html 
				));
	}
}

include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');
class Version extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!integer','product','Product'),
			DBColumn::make('text', 'version', 'Version'),
			DBColumn::make('tinymce', 'history', 'Version History'),
		);
		return new DBTable("ecomm_product_version", __CLASS__, $cols);
	}
	
	public static function getAll($productId){
		if (!$productId)
			return array();
		$sql = 'select `id` from ecomm_product_version where product = "' . e($productId) . '"';
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as &$result) {
			$result = Version::make($result['id'],'Version');
		}
		return $results;
	}
	
	static function getQuickFormPrefix() {return 'version_';}
}
DBRow::init('Version');
?>