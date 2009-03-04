<?php
class NewMethod extends ECommShipping{
	public function __construct(){
		$this->shippingName = "NewMethod";
		$this->shippingDetails = "The description of NewMethod<br/>This is just a test method for<br>shipping";
	}
	
	public function calculateCost($session, $cartItems){
		return 2.99;
	}
	
	public function getAdminInterface($ECommModule){
		return "NewMethod charges a flat fee of $2.99 per shipping";
	}
}
?>