<?php
class Testimonials extends ECommProduct implements ECommProduct_interface {
	public function __construct(){
		$this->pluginName = "Product Testimonials";
		$this->pluginDetails = "Allows the user to leave a testimonial for the product.";
	}
	
	public function adminHookBeforeDisplayForm(&$product, &$form){
		$alternativePics = AlternativeImage::getAll($product->getId());
		foreach ($alternativePics as $image) {
			$form->addElement('dbimage', 'product_alternativepic_' . $image->getId(), $image->getImage() . "&w=300");
			$form->addElement('checkbox', 'product_delete_altimage_' . $image->getImage(), 'Delete');
		}
		$newAltImage = $form->addElement('file', 'product_alternativepic_upload', 'New Alternate Product Image');
	}
	
	/*public function adminHookBeforedelete(&$product){
		return (array('abort'=> '1', 'msg' => "Delete Testimonials!"));
	}*/
	
	public function clientHookBeforeDisplay(&$product, &$ecommModule){
		$testimonials = ProductTestimonial::getAll($product->getId());
		$ecommModule->smarty->assign('testimonials',$testimonials);
		$html = $ecommModule->smarty->fetch(SITE_ROOT . '/modules/EComm/plugins/products/templates/TestimonialDisplay.tpl');
		return (array(
					'HTML' => $html 
				));
	}
	
	/*public function clientHookBeforeAddToCart(&$product, &$ecommModule){
		$abort = 0;
		return (array(
				'abort' => $abort,
				'msg'   => 'You cannot add this product to the cart',
				'url'   => '/Store/Product/' . $product->getId()
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
	}*/
	
}

include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');
class ProductTestimonial extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'title', 'Title'),
			DBColumn::make('tinymce', 'body', 'Tesimonial'),
		);
		return new DBTable("ecomm_product_testimonials", __CLASS__, $cols);
	}
	
	public static function getAll($productId){
		if (!$productId)
			return array();
		$sql = 'select `id` from ecomm_product_testimonials where product = "' . e($productId) . '"';
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as &$result) {
			$result = ProductTestimonial::make($result['id'],'ProductTestimonial');
		}
		return $results;
	}
	
	static function getQuickFormPrefix() {return 'productTestimonial_';}
}
DBRow::init('ProductTestimonial');
?>