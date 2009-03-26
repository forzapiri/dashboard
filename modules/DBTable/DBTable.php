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

class Module_DBTable extends Module {
	
	public $icon = '/modules/DBTable/images/database_edit.png';
	
	private function refresh($id) {
		$rows = TableColumn::getAll("order by id", '');
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
	
	function getAdminInterface() {
		$id = @$_REQUEST['id'];
		extract ($this->refresh($id));
		$viewtable = null;

		$name = $id ? $col->get("table") : @$_REQUEST['table'];
		$mysqlTable = new MysqlTable($name);
		$action = @$_REQUEST['action'];
		switch ($action) {
		case 'createTable':
			$col = TableColumn::make();
			$form = $col->createTableForm('/admin/DBTable');
			if (!$form->isProcessed()) {
				return $form->display();
			}
			break;
		case 'view': 
			break;
		case 'addColumn':
		case 'addedit':
			if (!$id) $col = TableColumn::make();
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
		case 'sort':
			foreach (getSerializedRequest() as $i => $j) {
				$item = TableColumn::make($j);
				$item->setSort($i);
				$item->save();
			}
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
