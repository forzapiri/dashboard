<?php
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
				// var_log ("$dbname." . $column->name() . " type=$type and delayLoad is " . ($column->delayLoad() ? 'true' : 'false'));
				if (!$column->delayLoad() && in_array($type, array('mediumtext', 'longtext'))) {
					error_log ("WARNING:  Table $dbname column " . $column->name()
							   . " has a mediumtext or longtext field.  Delay load required due to mysqli bug.");
				}
			}
		}
		$select = "select " . $this->loadColumnNames() . " from `$dbname`";
		$this->select = $select;
		$this->fetchQuery  = new Query("$select where id=?", "i");
		$this->fetchAllQuery = new Query ($select, "");
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
			else $sql .= "`" . $column->name() . '`, ';
		}
		return trim($sql, ', ');
	}
	
	private $rowsWhere = array();
	function getAllRows($where = null) {
		if (@$this->rowsWhere[$where]) {return $this->rowsWhere[$where];}
		$name = $this->name();
		$class = $this->classname;
		$select = $this->select;
		$query = $where ? new Query ("$select $where", "") : $this->fetchAllQuery;
		$results = $query->fetchAll();
		foreach ($results as &$result) {
			$result = new $class ($result);
			$this->rows[$result->get('id')] = $result;
		}
		$this->rowsWhere[$where] = $results;
		return $results;
	}
}
