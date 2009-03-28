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

define('SANITY_CHECK', true);
if (SANITY_CHECK) {// todo: See if SANITY CHECK is on
	require_once SITE_ROOT . '/modules/DBTable/include/MysqlTable.php';
}
class DBTable {
	private $name; 
	private $columns;
	private $fetchQuery;
	private $deleteQuery;
	private $select; // "select `col1`, `col2` from `tablename`"
	private $rows = array(); // Cache for maintaining loaded rows of the DB
	function DBTable($dbname, $classname, $columns) {
		$this->name = $dbname;
		$this->classname = $classname;
		if (SANITY_CHECK) {// todo: See if SANITY CHECK is on
			$mysqlTable = new MysqlTable("$dbname");
		}
		foreach ($columns as $key => $column) {
			if (is_string ($column)) {
				$column = DBColumn::make($column);
			}
			$this->columns[$column->name()] = $column;
			$sql = "select `" . $column->name() . "` from `$dbname` where id=";
			$column->setLoadSQL ($sql);
			$column->setLoadQuery (new Query ("$sql?", "i"));
			if (SANITY_CHECK) {// todo: See if SANITY CHECK is on
				$type = $mysqlTable->getType($column->name());
				if (!$column->delayLoad() && in_array($type, array('mediumtext', 'longtext'))) {
					error_log ("WARNING:  Table $dbname column " . $column->name()
							   . " has a mediumtext or longtext field.  Delay load required due to mysqli bug.");
				}
			}
		}
		$select = "select " . $this->loadColumnNames() . " from `$dbname`";
		$this->count = "select count(*) from `$dbname`";
		$this->select = $select;
		$this->fetchQuery  = new Query("$select where id=?", "i");
		$this->fetchAllQuery = new Query ($select, "");
		$this->countAllQuery = new Query ($this->count, "");
		$this->deleteQuery = new Query("delete from `$dbname` where id=?", "i");
		
	}
	function setCache($id, $obj) {$this->rows[$id] = $obj;}
	function getCache($id) {return @$this->rows[$id];}
	function resetWhereCache() {$this->rowsWhere = array();}
	function deleteRow ($id) {
		$this->deleteQuery->query($id);
		$this->resetWhereCache();
		$this->rows[$id] = false;
	}
	function fetchRow ($id) {
		return $this->fetchQuery->fetch($id);
	}
	function column ($name) {return $this->columns[$name];}
	function columns() {return $this->columns;}
	function name() {return $this->name;}

	public function loadColumnNames() {
		$sql = "";
		foreach ($this->columns as $column) {
			if ($column->delayLoad() || $column->ignored()) continue;
			else $sql .= $this->name . ".`" . $column->name() . '`, ';
		}
		return trim($sql, ', ');
	}
	
	private $rowsWhere = array();
	// NOTE THAT THE FOLLOWING TWO FUNCTIONS DIFFER IN ONLY ONE PLACE: true/false
	function getAllRows($where=null, $code=null) {
		$args = func_get_args();
		array_unshift ($args, false);
		return call_user_func_array (array ($this, 'getCountOrRows'), $args);
	}

	function getCount($where=null, $code=null) {
		$args = func_get_args();
		array_unshift ($args, true);
		return call_user_func_array (array ($this, 'getCountOrRows'), $args);
	}

	private function getCountOrRows($count = false, $where=null, $code=null) {
		$fname = $count ? "getCount" : "getAll";
		$index = "$fname: $where";
		if (!$code && @$this->rowsWhere[$index]) {return $this->rowsWhere[$index];}
		$name = $this->name();
		$class = $this->classname;
		$select = $count ? $this->count : $this->select;
		if ($where && $code === null) {
			$f = SiteConfig::programmer(true) ? 'trigger_error' : 'error_log';
			$f("$fname has been promoted to using prepared statements for the where clause\n"
						   . "For example, $fname('where id=? and title=?', 'is', 23, 'Fun')");
		}
		if ($code !== null) {
			if (func_num_args() != 3+strlen($code))
				trigger_error ("Length of code does not match number of arguments in DBTable::getCountOrRows()");
			$args = func_get_args();
			array_shift($args);
			array_shift($args);
			array_shift($args);
		} else {
			$code = '';
			$args = array();
		}
		$query = $where ? new Query ("$select $where", $code) :
			($count ? $this->countAllQuery : $this->fetchAllQuery);
		$results = call_user_func_array (array($query, 'fetchAll'), $args);
		if ($count) {
			$results = $results[0]['count(*)'];
		} else {
			foreach ($results as &$result) {
				$result = DBRow::make ($result, $class);
			}
		}
		if (!$code) $this->rowsWhere[$index] = $results;
		return $results;
	}
}
