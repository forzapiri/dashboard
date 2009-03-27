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
