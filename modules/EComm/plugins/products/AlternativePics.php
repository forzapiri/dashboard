<?php
class AlternativePics extends ECommProduct{
	public function __construct(){
		$this->pluginName = "Alternative images";
		$this->pluginDetails = "Allow the administrator to upload more than one image per product";
	}
	
	public function adminHookBeforeDisplayForm(&$product, &$form){
		$alternativePics = AlternativeImage::getAll($product->getId());
		foreach ($alternativePics as $image) {
			$form->addElement('dbimage', 'product_alternativepic_' . $image->getId(), $image->getImage() . "&w=300");
			$form->addElement('checkbox', 'product_delete_altimage_' . $image->getImage(), 'Delete');
		}
		$newAltImage = $form->addElement('file', 'product_alternativepic_upload', 'New Alternate Product Image');
	}
	
	public function adminHookAfterSave(&$product, &$form){
		if (!$product->getId())
			return "";
		$alternativePics = AlternativeImage::getAll($product->getId());
		foreach ($alternativePics as $image) {
			if (@$_REQUEST["product_delete_altimage_" . $image->getImage()]){
				$image->delete();
			}
		}	
		$newAltImage = $form->addElement('file', 'product_alternativepic_upload', 'New Alternate Product Image');
		if ($newAltImage->isUploadedFile()) {
			$im = new Image();
			$imageId = $im->insert($newAltImage->getValue());
			$obj = DBRow::make('', 'AlternativeImage');
			$obj->setProduct($product->getId());
			$obj->setImage($imageId);
			$obj->save();
		}
	}
	
	public function adminHookBeforedelete(&$product){
		//return (array('abort'=> '1', 'msg' => "You cannot delete products"));
	}
	
	public function adminHookBeforeDisplayOrder(&$orderDetail){
		$altPics = AlternativeImage::getAll($orderDetail->getProduct());
		$html = "";
		foreach ($altPics as $pic)
			$html .= "<img src=\"/images/image.php?id=" . $pic->getImage() . "&cliph=50\">";
		return (array(
					'HTML' => $html 
				));
	}
	
	public function clientHookBeforeDisplayProduct(&$product, &$ecommModule){
		$altPics = AlternativeImage::getAll($product->getId());
		$ecommModule->smarty->assign('altPics', $altPics);
		$ecommModule->smarty->assign('product', $product);
		$html = $ecommModule->smarty->fetch(SITE_ROOT . '/modules/EComm/plugins/products/templates/AlternativePicsClient.tpl');
		$ecommModule->addJS('/modules/EComm/plugins/products/js/AlternativePics.js');
		return (array(
					//'abort'=> '1', 
					//'msg' => 'hi there',
					'HTML' => $html 
				));
	}
	
	public function clientHookBeforeAddToCart(&$product, &$ecommModule){
		$abort = 0;
		return (array(
				'abort' => $abort,
				'msg'   => 'You cannot add this product to the cart',
				'url'   => Module_EComm::getModulePrefix() . 'Product/' . $product->getId()
			));
	}
	
	public function clientHookAfterAddToCart(&$cartItem, &$ecommModule){
		//Do whatever you want on the newly added item ($cartItem)
	}
	
	public function clientHookBeforeDisplayCartItem(&$cartItem, &$ecommModule){
		$product = $cartItem->getCartItemProduct();
		$altPics = AlternativeImage::getAll($product->getId());
		$ecommModule->smarty->assign('altPics', $altPics);
		$ecommModule->smarty->assign('product', $product);
		$html = $ecommModule->smarty->fetch(SITE_ROOT . '/modules/EComm/plugins/products/templates/AlternativePicsClient.tpl');
		$ecommModule->addJS('/modules/EComm/plugins/products/js/AlternativePics.js');
		return (array(
					//'abort'=> '1', 
					//'msg' => 'hi there',
					'HTML' => $html 
				));
	}
	
	public function calculatePrice(&$cartItem){
		return 2.50;
	}
	
}

include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');
class AlternativeImage extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!integer', 'product', 'Product'),
			DBColumn::make('!integer', 'image', 'Image'),
		);
		return new DBTable("ecomm_product_alternative_image", __CLASS__, $cols);
	}
	
	public static function getAll($productId){
		if (!$productId)
			return array();
		$sql = 'select `id` from ecomm_product_alternative_image where product = "' . e($productId) . '"';
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'AlternativeImage');
		}
		return $results;
	}
	
	static function getQuickFormPrefix() {return 'alternativeimage_';}
}
DBRow::init('AlternativeImage');
?>