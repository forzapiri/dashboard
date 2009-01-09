<?php

class Permission extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('!select', 'key', 'Key', array('view' => 'View', 'addedit'=>'Add / Edit', 'delete' => 'Delete')),
			DBColumn::make('!text', 'name', 'Name'),
			DBColumn::make('text', 'description', 'Description'),
			DBColumn::make('!text', 'class', 'Class'),
			DBColumn::make('Group(name)', 'group_id', 'Group Name'),
			'//status'
			);
		return new DBTable("permissions", __CLASS__, $cols);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}
	static function getAll($where = null) {
		$perms = self::$tables[__CLASS__]->getAllRows($where);
		return $perms;
	}
	
	static function hasPerm($group, $class, $key) {
		return self::getAll('where group_id="'. $group . '" and class="' . $class . '" and `key`="' . $key . '" and status=1');
	}
	
	function quickformPrefix() {return 'permissions_';}
	
}
DBRow::init('Permission');

?>