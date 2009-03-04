<?php
interface ECommProduct_interface {
	public function adminHookBeforeDisplayForm(&$product, &$form);
	public function adminHookBeforeSave(&$product, &$form);
	public function adminHookAfterSave(&$product, &$form);
	public function adminHookBeforeDelete(&$product);
	public function adminHookAfterDelete(&$product);
	
	public function clientHookBeforeDisplayProduct(&$product, &$ecommModule);
	public function clientHookBeforeAddToCart(&$product, &$ecommModule);
	public function clientHookAfterAddToCart(&$cartItem, &$ecommModule);
	public function clientHookBeforeDisplayCartItem(&$cartItem, &$ecommModule);
	public function calculatePrice(&$cartItem);
}
?>