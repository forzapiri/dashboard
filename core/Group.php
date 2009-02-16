<?php

class Group extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Group Name')
			);
		return new DBTable("auth_groups", __CLASS__, $cols);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}
	static function getAll($where = null) {return parent::getAll($where, __CLASS__);}
	function quickformPrefix() {return 'group_';}
	
	public function getCountMembers() {
		$sql = 'select count(id) as count from auth where `group`=' . $this->get('id');
		$members = Database::singleton()->query_fetch($sql);
		return $members['count'];
	}
	
	public static function toArray() {
		$groups = self::getAll();
		$array = array();
		foreach ($groups as $group) {
			$array[$group->getId()] = $group->getName();
		}
		return $array;
	}

}
DBRow::init('Group');
?>