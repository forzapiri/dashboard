<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

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