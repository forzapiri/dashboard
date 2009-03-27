<?php

class MailReport {
	
	protected $send = null;
	
	protected $distribution = null;
	
	protected $views = null;
	
	
	public function __construct( $mso_id ) {
		$this->send = new MailSendOut($mso_id);
		
		$sql = 'select * from mail_delivery_log where mso_id=' . e($mso_id);
		$this->distribution = Database::singleton()->query_fetch_all($sql);
		
		$this->views = MailViewLog::getAllMailViewLogs($mso_id);
	}
	
	public function getId() {
		return $this->send->getId();
	}
	
	public function getSubject() {
		return $this->send->getSubject();
	}
	
	public function getDate() {
		return $this->send->getTimestamp();
	}
	
	public function getList() {
		
	}
	
	public function getViews() {
		return $this->views;
	}
	
	public function getListName() {
		return $this->send->getListName();
	}
	
	public function getListDistribution() {
		return $this->send->getListCount();
	}
	
	public function getSentCount() {
		return count($this->distribution);
	}
	
	public function getCompletedPercent() {
		if ( $this->send->getListCount() == 0 ) return 0;
		return 100 * (count($this->distribution) / $this->send->getListCount());
	}
	
	public static function getAllReports() {
		$sql = 'select mso_id from mail_sendout order by mso_timestamp desc';
		$rs = Database::singleton()->query_fetch_all($sql);
		
		foreach ($rs as &$r) {
			$r = new MailReport($r['mso_id']);
		}
		return $rs;
	}
	
}

?>