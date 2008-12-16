<?php
class MysqlTable {
	private $tableExists = false;
	private $name;
	private $columns;
	private $types;
	
	function MysqlTable ($name) {
		$this->name = $name;
		if (!$this->exists()) return;
		$this->loadTableInfo();
	}

	private static $dbtables = false;
	public function exists () {
		if (!self::$dbtables) {
			$query = new Query("show tables", '');
			array_flatten ($query->fetchAll(), 0, self::$dbtables);
		}
		return !!array_search ($this->name, self::$dbtables);
	}
	
	private function loadTableInfo () {
		$query = new Query ("describe `$this->name`", '');
		$this->columns = $query->fetchAll();
		$this->types = array();
		foreach ($this->columns as $col) {
			$this->types[$col['Field']] = $col['Type'];
		}
	}

	public function getType ($column) {return @$this->types[$column];}

	public function create() {
		$query = new Query ("create table if not exists `$this->name` (
			`id` int(10) unsigned NOT NULL auto_increment,
			primary key (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;"
		);
		$query->query();
	}

	public function setType ($column, $type) {
		$sql = "alter table `$this->name` "; 
		$sql .= isset($this->types[$column]) ? "change `$column`" : 'add';
		$sql .= " `$column` $type";
		$query = new Query ($sql, '');
		$query->query();
		$this->types[$column] = $type;
	}
}
