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

class OrderDetail extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('integer', 'order_nb', 'Order'),
			DBColumn::make('integer', 'product', 'Product'),
			DBColumn::make('text', 'product_name', 'Product Name'),
			DBColumn::make('integer', 'quantity', 'Quantity'),
		);
		return new DBTable("ecomm_order_detail", __CLASS__, $cols);
	}
	
	public static function getAll($orderId=0){
		$sql = 'select `id` from ecomm_order_detail';
		if ($orderId)
			$sql .= " where order_nb = '" . e($orderId) . "'";
		$sql .= " order by id";
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'OrderDetail');
		}
		return $results;
	}
	
	public function getProductPluginInfo(){
		require_once SITE_ROOT . '/modules/EComm/plugins/products/ECommProduct.php';
		$hookResults = ECommProduct::adminPluginHooks("BeforeDisplayOrder", $this);
		$result = "";
		foreach ($hookResults as $pluginResult)
			$result .= $pluginResult["HTML"];
		return $result;
	}
	
	static function getQuickFormPrefix() {return 'orderdetail_';}
}
DBRow::init('OrderDetail');
?>