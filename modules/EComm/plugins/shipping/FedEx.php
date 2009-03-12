<?php
class FedEx extends ECommShipping{
	public function __construct(){
		$this->shippingName = "Federal Express";
		$this->shippingDetails = "The description of FedEx";
	}
	
	public function calculateCost($session, $cartItems){
		return 4.99;
	}
	
	public function getAdminInterface($ECommModule){
		return "Fedex charges a flat fee of $4.99 per shipping";
	}
}
?>