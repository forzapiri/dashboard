<?php
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
			$result = PaypalIPN::make($result['id'],'PaypalIPN');
		}
		return $results;
	}
	
	static function getQuickFormPrefix() {return 'paypalipn_';}
}
DBRow::init('PaypalIPN');
