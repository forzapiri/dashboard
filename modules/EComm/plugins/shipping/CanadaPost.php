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