<?php
class EAndA extends ECommShipping{
	public function __construct(){
		$this->shippingName = "E & A";
		$this->shippingDetails = "We deliver";
	}
	
	public function calculateCost($session, $cartItems){
		/*
		 * The shipping cost is calculated as the following:
		 * The pallet count is how many items can fit onto one pallet.
		 * We ship items by pallets and determine our delivery costs by how many pallets are shipped. 
		 * If we're shipping 20 bags of product X and 40 bags of products Y where:
		 * pallet count of X is 10
		 * pallet count of Y is 5
		 * That means that we are shipping: 2 pallets for X and 8 pallets for Y. Thus 10 pallets in total
		 * 
		 * The Shipping rates will be determined by the number of pallets each order makes up AND also by the total cost (before GST) for the order.
		 * Freight charges:
		 * $70/pallet on orders up to $499
		 * $60/pallet on orders $550 - $999
		 * $50/pallet on orders +$1000
		 */
		if (!is_array($cartItems))
			return 0.00;
		$totalAmount = 0.00;
		$palletCount = 0.00;
		foreach ($cartItems as $item) {
			$product = $item->getCartItemProduct();
			$productProperty = ProductPropertiesTbl::getPropertiesBasedOnProductId($product->getId());
			$totalAmount += $product->getPrice() * $item->getQuantity();
			if ($productProperty->getPalletCount() != 0){
				$palletCount += $item->getQuantity() / $productProperty->getPalletCount();
			}
			else{
				$palletCount += 0;
			}
		}
		$palletCount = ceil($palletCount);//Round up the number of pallets to an integer number
		if ($totalAmount >= 1000)
			return SiteConfig::get("Cart::ShippingCostMoreThan1000") * $palletCount;
		elseif ($totalAmount >= 500)
			return SiteConfig::get("Cart::ShippingCostLessThan999") * $palletCount;
		else
			return SiteConfig::get("Cart::ShippingCostLessThan499") * $palletCount;
	}
	
	public function getAdminInterface($ECommModule){
		$st = "";
		$st = str_replace(" ", "&nbsp;", $st);
		$st = str_replace("\n", "<br/>", $st);
		return $st;
	}
}
?>