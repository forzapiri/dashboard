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

class OrderComment extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('//integer', 'order_nb', 'Order'),
			DBColumn::make('select', 'status', 'Order Status', array("Pending"=>"Pending","Shipped"=>"Shipped","Complete"=>"Complete")),
			DBColumn::make('textarea', 'comment', 'Comment'),
		);
		return new DBTable("ecomm_order_comment", __CLASS__, $cols);
	}
	
	public function getAddEditFormHook($form){
		$form->setConstants( array ( 'order_id' => $this->getOrderNb() ) );
		$form->addElement( 'hidden', 'order_id' );
	}
	
	public static function getAll($orderId=0){
		$sql = 'select `id` from ecomm_order_comment';
		if ($orderId)
			$sql .= " where order_nb = '" . e($orderId) . "'";
		$sql .= " order by id";
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'OrderComment');
		}
		return $results;
	}
	static function getQuickFormPrefix() {return 'ordercomment_';}
}
DBRow::init('OrderComment');
?>