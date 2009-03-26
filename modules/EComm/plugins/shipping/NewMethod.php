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