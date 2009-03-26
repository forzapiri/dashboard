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

class NewPaymentMethod extends ECommPayment{
	public function __construct(){
		$this->paymentName = "New Method";
		$this->paymentDetails = "This is the New Method option<br/>
								 This is another alternative to paypal";
	}

	public function getPaymentForm(){
		return "This payment method is coming soon<br>";
	}
	
	//This method does the actual payment.
	//For example, it will be called when PayPal IPN arrives, or when the credit card is charged
	public function doPayment(){
		return true;
	}
}
?>