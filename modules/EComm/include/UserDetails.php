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

include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');

class UserDetails extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('//integer', 'user', 'User'),
			DBColumn::make('//text', 'phone_number', 'Phone number'),
			DBColumn::make('//integer', 'shipping_address', 'Shipping Address'),
			DBColumn::make('//integer', 'billing_address', 'Billing Address'),
		);
		return new DBTable("ecomm_user_details", __CLASS__, $cols);
	}
	
	public static function getUserDetailsBasedOnUserId($userId){
		$sql = 'select `id` from ecomm_user_details where user = "' . e($userId) . '"';
		$result = Database::singleton()->query_fetch($sql);
		if (!@$result['id']){
			$obj = DBRow::make('', 'UserDetails');
			$obj->setUser($userId);
			$obj->save();
		}
		else{
			$obj = DBRow::make($result['id'], 'UserDetails');
		}
		return $obj;
	}
	
	public function getAddress($type){
		if ($type == "billing_address"){
			$add = DBRow::make($this->getBillingAddress(), 'Address');
		}
		else{//$type is shipping_address
			$add = DBRow::make($this->getShippingAddress(), 'Address');
		}
		return $add;
	}
	
	public function setAddress($type, $address){
		if ($type == "shipping_address"){
			$this->setShippingAddress($address->getId());
		}
		else{//$type is billing_address
			$this->setBillingAddress($address->getId());
		}
	}
	
	static function getQuickFormPrefix() {return 'userdetails_';}
}
DBRow::init('UserDetails');
?>