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

class Order extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'tid', 'Transaction ID'), 
			DBColumn::make('integer', 'user', 'User'),
			DBColumn::make('text', 'customer_name', 'Customer Name'),
			DBColumn::make('text', 'user_email', 'Customer Email'),
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
		return new DBTable("ecomm_order", __CLASS__, $cols);
	}
	
	public static function getAll($allOrders = false, $userId = null){
		$sql = 'select `id` from ecomm_order where 1=1';
		if (!$allOrders)
			$sql .= ' and status not like "Complete"';
		if ($userId)
			$sql .= ' and user = "' . e($userId) . '"';
		$sql .= ' order by id desc';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'Order');
		}
		return $results;
	}
	static function getQuickFormPrefix() {return 'order_';}
}
DBRow::init('Order');
?>