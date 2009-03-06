<?php
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
			$obj = UserDetails::make(null,'UserDetails');
			$obj->setUser($userId);
			$obj->save();
		}
		else{
			$obj = UserDetails::make($result['id'],'UserDetails');
		}
		return $obj;
	}
	
	public function getAddress($type){
		if ($type == "billing_address"){
			$add = Address::make($this->getBillingAddress(),'Address');
		}
		else{//$type is shipping_address
			$add = Address::make($this->getShippingAddress(),'Address');
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
