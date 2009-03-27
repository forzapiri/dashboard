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

function _TableColumn_tableNew($el, $table) {return !TableColumn::getAllRows($table);}
class TableColumn extends DBRow {
	function createTable() {
		$cols = array (
			'id?',
			DBColumn::make('html', 'types', 'Type names'),
			DBColumn::make ('?text', 'table', 'Table name'),
			DBColumn::make ('text', 'type', 'Column type'),
			DBColumn::make ('text', 'label', 'Label'),
			DBColumn::make ('text', 'name', 'Column name'),
			'//sort',
			DBColumn::make ('select', 'modifier', 'Modifier', array ('' => '', 
																	 'hidden' => 'Hidden',
																	 'required' => 'Required',
																	 'no form' => 'No Form Entry')),
			);
		$result = new DBTable("dbtable", __CLASS__, $cols);
		return $result;
	}
	function __construct($id=null) {
		if ($id === DUMMY_INIT_ROW) {return;}
		parent::__construct($id);
		$this->setTypes("<b>Column Type</b> possibilities:
		       <ol><li>&nbsp; - A class name like Menu or User (must be capitalized)</li>
			       <li>&nbsp; - A built-in type from " . implode(", ", DBColumn::getTypes()) . "<li>
			       <li>&nbsp; - enum takes args such as enum(yes,no,maybe)</li>
		       	</ol>");
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function countAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}

	static function getAllTables() {return self::getAll("where type='id'", '');}
	static function getAllRows($table) {return self::getAll("where `table`=?", 's', $table);}
	
	function suggestedMysql() {
		$t = DBColumn::make($this->get('type'));
		return $t->suggestedMysql();
	}
	
	function createTableForm($target = '/admin/DBTable') {
		$formName = get_class($this) . '_createTable';
		$form = new Form($formName, 'get', $target);
		$form->registerRule ('table_new', 'function', '_TableColumn_tableNew');
		$form->setConstants (array ('action' =>'createTable'));
		$form->addElement ('hidden', 'action');
		$form->addElement ('text', 'table', 'Table name');
		$form->addRule ('table', 'Table already exists', 'table_new');
		$form->addRule('table', "Table name required", 'required', 'client');
		
		$form->addElement('submit', 'submit', 'Submit');
		if ($form->isSubmitted() && isset($_REQUEST['submit']) && $form->validate()) {
			$this->set('table', $form->getElementValue('table'));
			$this->set('type', 'id');
			$this->set('name', 'id');
			$this->set('modifier', 'hidden');
			$this->save();
			$form->setProcessed();
		}
		return $form;
	}
}
DBRow::init('TableColumn');
