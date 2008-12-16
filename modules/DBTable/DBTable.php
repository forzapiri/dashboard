<?php
/**
 * DBTable Module
 * @author David Wolfe <wolfe@norex.ca>
 * @package Modules
 */

/**
 * DBTable
 * 
 * This provides an interface for adding and removing database table columns for an existing module.
 * 
 * @package Modules
 * @subpackage Skeleton
 */

class Module_DBTable extends Module {
	private function refresh($id) {
		$rows = TableColumn::getAll(" order by id");
		$tables = array();
		foreach ($rows as $row) {
			$table = $row->getTable();
			if (!isset ($tables[$table])) {
				$tables[$table] = array();
			}
			$tables[$table][] = $row;
			if ($row->getId() == $id) {
				$col = $row;
			}
		}
		return array ('tables' => $tables, 'rows' => $rows, 'col' => @$col); 
	}
	
	private static $dbtables = false;
	private function tableExists ($table) {
		error_log("Can you use MysqlTable::tableExists instead of DBTable.php's ??");
		// TODO: Code duplicated in MysqlTable.  Use it.
		if (!self::$dbtables) {
			$query = new Query("show tables", '');
			array_flatten ($query->fetchAll(), 0, $dbtables);
		} else return !!array_search ($table, self::$dbtables);
	}
	
	private function loadTableInfo ($table) { // $table is a string
		// TODO: Code duplicated in MysqlTable.  Use it.
		if (!$this->tableExists($table)) {return;}
		$query = new Query ("describe `$table`", '');
		$cols = $query->fetchAll();
		foreach ($cols as $c) {
			$name = $c['Field'];
			if ($name == 'id') continue;
			$col = new TableColumn ();
			$col->set('table', $table);
			$col->set('name', $name);
			$col->set('type', 'text'); // TODO: Guess the field type?  Don't bother?
			$col->set('label', ucwords(str_replace('_', ' ', $name)));
			$col->save();
		}
	}
	
	function getAdminInterface() {
		$id = @$_REQUEST['id'];
		extract ($this->refresh($id));
		$viewtable = null;

		$name = $id ? $col->get("table") : @$_REQUEST['table'];
		$mysqlTable = new MysqlTable($name);
		$action = @$_REQUEST['action'];
		switch ($action) {
			case 'createTable':
				$col = new TableColumn ();
				$form = $col->createTableForm('/admin/DBTable');
				if (!$form->isProcessed()) {
					return $form->display();
				} else {
					$this->loadTableInfo($name);
				}
				break;
			case 'view': 
				break;
			case 'addColumn':
			case 'addedit':
				if (!$id) $col = new TableColumn ();
				$col->set('table', $name);
				$form = $col->getAddEditForm('/admin/DBTable');
				if (!$form->isProcessed()) {
					return $form->display();
				}
				break;
			case 'setType':
				$mysqlTable->create(); // Creates only if not already created
				$mysqlTable->setType($col->getName(), $col->suggestedMysql());
				break;			
			case 'delete':
				$col->delete();
				$col = null;
				break;
		}
		extract ($this->refresh($id));
		if ($name) $viewtable = $tables[$name];
		$smarty = $this->smarty;
		$smarty->assign ('name', $name);
		$smarty->assign('tables', $tables);
		$smarty->assign ('viewtable', $viewtable);
		$smarty->assign ('mysqltable', $mysqlTable);
		return $smarty->fetch( 'admin/tables.tpl' );
	}
}

?>