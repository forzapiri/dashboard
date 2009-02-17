<?php

class analytics extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('code', 'content', 'Content'),
			'timestamp'
			);
		return new DBTable("analytics", __CLASS__, $cols);
	}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	function quickformPrefix() {return 'analytics_';}

	static function getAllAnalyticss ($status = null) {
		if($status == 'active'){
			return self::getAll("where status=1");
		} else {
			return self::getAll();
		}
	}
}
DBRow::init('analytics');

?>