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
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}

	static private $warned = false;
	static function hasPerm($group, $class, $key) {
		$perm = self::getAll('where group_id=? and class=? and `key`=? and status=1', 'iss',
							 $group, $class, $key);
		if ($perm) {
			return true;
		} else if (SiteConfig::norex()) {
			if (!self::$warned) {
				trigger_error ("Warning: norex() circumventing non-existent permission $group $class $key (limit of one such warning given)");
				self::$warned = true;
			}
			return true;
		} else return false;
	}

	function quickformPrefix() {return 'permissions_';}
	
}
DBRow::init('Permission');
