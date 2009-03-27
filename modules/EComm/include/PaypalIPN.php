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

class PaypalIPN extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('integer', 'is_verified', 'Is Verified'),
			DBColumn::make('text', 'transaction', 'Transaction'),
			DBColumn::make('text', 'txnid', 'Paypal Transaction ID'),
			DBColumn::make('text', 'payment_status', 'Payment Status'),
			DBColumn::make('text', 'post_string', 'Post fields'),
			DBColumn::make('text', 'memo', 'Memo')
		);
		return new DBTable("ecomm_paypal_ipn", __CLASS__, $cols);
	}
	
	public static function getAll($sessionId=0){
		$sql = 'select `id` from ecomm_paypal_ipn';
		if ($sessionId)
			$sql .= " where session = '" . e($sessionId) . "'";
		$sql .= " order by id";
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'PaypalIPN');
		}
		return $results;
	}
	
	static function getQuickFormPrefix() {return 'paypalipn_';}
}
DBRow::init('PaypalIPN');
?>