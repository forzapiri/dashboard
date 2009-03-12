<?php
include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');

class Session extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'ip_address', 'IP Address'),
			DBColumn::make('select', 'status', 'Status',array('1'=>'Active','0'=>'Inactive')),
			DBColumn::make('integer', 'user', 'User'),
			DBColumn::make('text', 'shipping_class', 'Shipping Class'),
			DBColumn::make('text', 'payment_class', 'Payment Class'),
		);
		return new DBTable("ecomm_session", __CLASS__, $cols);
	}
	
	public static function getActiveSession($sessionId=null, $filter = true){
		if ($sessionId == null){
			$sessionId = @$_SESSION["ECommSessionId"];
		}
		$sql = 'select `id` from ecomm_session where id = "' . e($sessionId) . '"';
		if ($filter)
			$sql .= " and status = 1";
		
		$result = Database::singleton()->query_fetch($sql);
		if (!$result){
			$session = DBRow::make('', 'Session');
			$session->setIpAddress($_SERVER['REMOTE_ADDR']);
			$session->setStatus(1);
			$session->save();
			$_SESSION["ECommSessionId"] = $session->getId();
		}
		else{
			$session = DBRow::make($result['id'], 'Session');
		}
		return $session;
	}
	
	//This method will be called right after the transaction is created.
	//Its purpose is to disallow the client from messing with the old session by adding new products for example.
	public function reGenerateSession(){
		$newSession = DBRow::make('', 'Session');
		$newSession->setIpAddress($this->getIpAddress());
		$newSession->setStatus($this->getStatus());
		$newSession->setUser($this->getUser());
		$newSession->setShippingClass($this->getShippingClass());
		$newSession->setPaymentClass($this->getPaymentClass());
		$newSession->save();
		$_SESSION["ECommSessionId"] = $newSession->getId();
		return $newSession->getId();
	}
	
	public static function getAll($filter = true){
		$sql = 'select `id` from ecomm_session';
		if ($filter)
			$sql .= " where status = 1";
		
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'Session');
		}
		
		return $results;
	}
	static function getQuickFormPrefix() {return 'session_';}
}
DBRow::init('Session');
?>