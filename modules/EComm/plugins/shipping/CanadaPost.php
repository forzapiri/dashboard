<?php
class CanadaPost extends ECommShipping{
	public function __construct(){
		$this->shippingName = "Canada Post";
		$this->shippingDetails = "The description of Canada Post";
	}
	
	public function calculateCost($session, $cartItems){
		//Here is an example, lets say that the shipping cost is one dollar per shipped item
		//Also, there is an international fee of $20 that will apply if the shipping address is not in Canada
		$result = 20.00;
		foreach ($cartItems as $cartItem){
			$result += $cartItem->getQuantity();
		}
		if (!@$_SESSION['authenticated_user'])
			return $result;
		$userId = @$_SESSION['authenticated_user']->getId();
		$userDetails = UserDetails::getUserDetailsBasedOnUserId($userId);
		$shippingAddress = $userDetails->getAddress('shipping_address');
		if ($shippingAddress->getCountryName() == "Canada")
			$result -= 20.00;
		return $result;
	}
	
	public function getAdminInterface($ECommModule){
		return "Canada Post charges a flat fee of $9.99 per shipping";
	}
}
?>