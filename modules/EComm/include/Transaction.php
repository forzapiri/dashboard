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

class Transaction extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'tid', 'Transaction ID'), 
			DBColumn::make('integer', 'session', 'Session ID'),
			DBColumn::make('integer', 'user', 'User'),
			DBColumn::make('text', 'phone', 'Phone number'), 
			DBColumn::make('text', 'shipping_street', 'Shipping street'), 
			DBColumn::make('text', 'shipping_city', 'Shipping City'), 
			DBColumn::make('text', 'shipping_postal', 'Shipping Postal'), 
			DBColumn::make('text', 'shipping_province', 'Shipping Province'), 
			DBColumn::make('text', 'shipping_country', 'Shipping Country'), 
			DBColumn::make('text', 'billing_street', 'Billing Street'), 
			DBColumn::make('text', 'billing_city', 'Billing City'), 
			DBColumn::make('text', 'billing_postal', 'Billing Postal'), 
			DBColumn::make('text', 'billing_province', 'Billing Province'), 
			DBColumn::make('text', 'billing_country', 'Billing Country'), 
			DBColumn::make('float', 'cost_subtotal', 'Sub Total'), 
			DBColumn::make('float', 'cost_tax', 'Tax'), 
			DBColumn::make('float', 'cost_shipping', 'Shipping Cost'), 
			DBColumn::make('float', 'cost_total', 'Total'), 
			DBColumn::make('text', 'ip', 'IP Address'), 
			DBColumn::make('text', 'shipping_class', 'Shipping Class'), 
			DBColumn::make('text', 'payment_class', 'Payment Class'), 
			DBColumn::make('text', 'created', 'Timestamp'),
			DBColumn::make('textarea', 'delivery_instructions', 'Delivery Instructions'),
			DBColumn::make('text', 'status', 'Status'),
		);
		return new DBTable("ecomm_transaction", __CLASS__, $cols);
	}
	
	public static function getTransactionBasedOnTID($tid){
		$sql = 'select `id` from ecomm_transaction  where tid like "' . e($tid) . '"';
		$result = Database::singleton()->query_fetch($sql);
		$obj = DBRow::make($result['id'], 'Transaction');
		return $obj;
	}
	
	public static function generateNewTID(){
		srand ((double) microtime( ) * 1000000);
		$tid = "";
		for ($i = 0; $i < 30; $i++)
			$tid .= rand(1, 9);
		return $tid;
	}
	
	public static function getAll(){
		$sql = 'select `id` from ecomm_transaction';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'Transaction');
		}
		return $results;
	}
	static function getQuickFormPrefix() {return 'transaction_';}
}
DBRow::init('Transaction');
?>