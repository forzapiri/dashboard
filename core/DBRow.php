<?
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

/* NOTE:  Class must be initialized by calling the static init() method. */

/*
 * TODO:
 * cache results of all loads
 * allow for default values for types
 */

/* DANGER: SPECIAL FUNCTIONS LIKE __serialize ARE INTERCEPTED BY __call. */
define ('DUMMY_INIT_ROW', -1);
include_once SITE_ROOT . '/modules/DBTable/include/TableColumn.php';

abstract class DBRow {
	public $chunkManager = false;  // TODO: Make private
	protected static $__CLASS__ = __CLASS__;
	protected static $tables = array();
	private $values = array();
	private static function _get_name($col) {
		if (is_object($col)) return $col->name();
		preg_match('/([a-zA-Z]+)/', $col, $matches);
		return $matches[1];
	}
	function createTable($table, $class, $customColumns = array()) {
		$cols = $customColumns;
		$columns = TableColumn::getAllRows($table);
		$done = array();
		foreach ($cols as $col) {
			$done[self::_get_name($col)] = true;
		}
		foreach ($columns as $col) {
			$name = $col->get('name');
			if (isset($done[$name]) && $name != 'id') {
				 error_log ("Warning: column $name is specified twice; check both in $class.php and in dbtable");
			} else {
				$cols[] = DBColumn::make ($col->get('type'), $name, $col->get('label'),
										  null, $col->get('modifier'));
				$done[$name] = true;
			}
		}
		$result = new DBTable($table, $class, $cols);
		return $result;
	}
	static function init($class) {
		self::$makeFlag = true;
		if (!isset (self::$tables[$class])) {
			$dummy = new $class(DUMMY_INIT_ROW);
			self::$tables[$class] = $dummy->createTable();
		}
	}
	function values() {return $this->values; }
	function table() {return self::$tables[get_class($this)];}
	function column($name) {return $this->table()->column($name);} 
	function columns() {return $this->table()->columns();}
	function quickformPrefix() {return "";}
	function chunkable() {return false;}
	public function chunks() { return Chunk::getAllContentFor($this, 'active');}
	function addElementTo($form, $id, $formValue) {
		switch ($id) {
		default: false;
		}
	}


	static function getAll($where = null, $class = null) { // OLD STYLE
		if (!$class) $class = self::$__CLASS__;
		$table = @self::$tables[$class];
		if (!$table) trigger_error("Table for $class does not yet exist");
		else return $table->getAllRows($where);
	}

	// NOTE THAT THE FOLLOWING TWO FUNCTIONS ONLY DIFFER IN ONE LINE --- THE call_user_func_array
	static function getAllRows($class = null, $where = null) { // NOTE THAT CLASS COMES FIRST
		if (!$class) $class = self::$__CLASS__;
		$table = @self::$tables[$class];
		$args = func_get_args();
		array_shift($args);
		if (!$table) trigger_error("Table for $class does not yet exist");
		else return call_user_func_array (array ($table, 'getAllRows'), $args);
	}

	static function getCountRows($class = null, $where = null) { // NOTE THAT CLASS COMES FIRST
		if (!$class) $class = self::$__CLASS__;
		$table = @self::$tables[$class];
		$args = func_get_args();
		array_shift($args);
		if (!$table) trigger_error("Table for $class does not yet exist");
		else return call_user_func_array (array ($table, 'getCount'), $args);
	}

	static $makeFlag = false;
	static function make($id, $class) {  // $id can be an array!
		if (is_string ($id) && is_string ($class) && class_exists ($class) && class_exists ($id)) {
			trigger_error ("I bet you have a call to $id::make($id, x) which should be $id::make(x) OR DBRow::make(x, $id)");
		}

		if (!class_exists ($class)) {
			$append = class_exists($id) ? "  Swap arguments!" : "";
			trigger_error (class_exists($id)
						   ? "Swap arguments to DBRow::make($id, id) so id comes first"
						   : "Class $class does not exist in DBRow::make()");
		}
		if ($id === null || $id === DUMMY_INIT_ROW) {
			self::$makeFlag = true;
			return new $class($id);
		}
		$table = @self::$tables[$class];
		if (!$table ) return new $class($id); // DOES NOT YET CACHE non-DBRow CLASSES
		$result = $table->getCache(is_array($id) ? $id['id'] : $id);
		if ($result) return $result;
		self::$makeFlag = true;
		$result = new $class ($id);
		$table->setCache(is_array($id) ? $id['id'] : $id, $result);
		return $result;
	}
	
	function __construct($id = null) {
		if (!self::$makeFlag) {
			trigger_error("Warning: running constructor without make");
		} else {
			self::$makeFlag = false;
		}
		if ($id === DUMMY_INIT_ROW) {return;}
		if ($this->chunkable() && !$this->chunkManager) {$this->chunkManager = new ChunkManager($this);}
		if (is_array ($id)) {
			$result = $id;
		} else if (is_null($id)) {
			$result = array();
		} else {
			$result = &$this->table()->fetchRow($id);
		}
		if ($result) {
			foreach ($result as $key => $value) {
				$column = @$this->column($key);
				if (!$column) {
					error_log ("Ignoring column ". $key);
					continue;
				}
				$this->set($key, $column->fromDB($value));
 			}
		}
		foreach ($this->columns() as $column) {
			$key = $column->name();
			if (!isset($this->values[$key])) $this->values[$key] = null; // TODO: SET TO DEFAULT VALUE
		}
	}
	
	function __call($name, $args) {
		$getset = $this->camel2getset ($name);
		switch ($getset[0]) {
			case 'get': return $this->get($getset[1]);
			case 'set': return $this->set($getset[1], $args[0]);
			default:
 				trigger_error("Undefined property via __get(): $name");
				return null;
		}
	}
	function get($name) {
		$result = $this->values[$name];
		$column = @$this->column($name);
		if (is_null($result) && $column && $column->delayLoad() && $this->values['id']) {
			$result = $column->fromDB($column->load($this->values['id']));
			$this->values[$name] = $result;
		}
		return $result;
	}
	function &set($name, $value) {
		if ($name == 'id' && $this->table()->getCache($value)  // SANITY CHECK
			&& @$this->values[$name] != $value) {
			$class = get_class($this);
			trigger_error ("Attempt to reset a DBRow id to an existing cached value; use DBRow::make($value, $class) or $class::make($value)");
		}
		if (isset($this->values[$name.'_id'])) { // Setting blah_id and blah
			$this->values[$name] = $value;
			$this->values[$name.'_id'] = $value->getId();
		} else if (substr($name, -3) === '_id') { // Setting blah_id and blah
			$column = $this->column ($name);
			$class = $column->type();
			$this->values[$name] = $value;
			if (class_exists ($class)) {
				$obj = DBRow::make($value,$class);
				$this->values[substr($name, 0, strlen($name)-3)] = $obj;
			}
		} else {
			$this->values[$name] = $value;
		}
		return $this;
	}

	function &delete() {
		if (!$this->get('id')) return $this;
		if ($this->chunkManager) Chunk::deleteAllFor($this);
		$this->table()->deleteRow($this->get('id'));
		$this->table()->resetWhereCache();
		return $this;
	}
	
	public function &toggle() {
		$this->toggleBeforeSaveHook();
		$this->set('status', 1 - $this->get('status'))->save();
		$this->table()->resetWhereCache();
		$this->toggleAfterSaveHook();
		return $this;
	}

	function &save() {
		// This version creates the query on a per-call basis.
		// This is useful if some entries of an object to "update" haven't been loaded.
		// TODO:  Implement a version that caches the prepared statement in other cases.
		$update = false;
		$sql = "";
		$types = '';
		$params = array();
		/* Build up sql prepared statement and type string in parallel */
		foreach ($this->columns() as $column) {
			$name = $column->name();
			$value = &$this->values[$name];
			if ($value === null) continue;
			if ($column->ignored()) continue;
			if ($name == 'id' && $value) {
				$update = $value;
			} else {
				$params[] = &$column->toDB($value, $this);
				$sql .= " `$name`=?,";
				$types .= $column->prepareCode();
			}
		}
		$sql = trim ($sql, ',');
		if (!$sql) {
			// Maybe wanted to just create an empty row?
			// trigger_error ("NO DATA IN DBRow! Class was " . get_class($this) . ":", E_USER_WARNING);
			$sql .= " () values ()";   // MYSQL's weird syntax for not specifying any columns
			if ($update) return $this; // NO CHANGES REQUIRED
		} else {
			$sql = " set $sql";
		}
		
		$table = $this->table()->name();
		if ($update === false) {
			$sql = "insert into `$table`" . $sql;
			$query = new Query ($sql, $types);
			$id = $query->insert($params);
			$this->values['id'] = $id;
			$this->table()->setCache($id, $this);
		} else {
			$sql = "update `$table`" . $sql . " where id=?";
			$params[] = $update;
			$types .= 'i';
			$query = new Query ($sql, $types);
			$query->query($params);
		}
		// There could be default values set in MySQL, so retrieve the object after saving it:
		self::$makeFlag = true;
		$this->__construct($this->getId());
		$this->table()->resetWhereCache();
		return $this;
	}
	
	function toggleAfterSaveHook() {}
	function toggleBeforeSaveHook() {}

	function getAddEditFormHook($form) {}
	function getAddEditFormSaveHook($form) {} // Method deprecated; called below for backward compatability
	function getAddEditFormBeforeSaveHook($form) {return $this->getAddEditFormSaveHook($form);}
	function getAddEditFormAfterSaveHook($form) {}
	function getAddEditForm($target = null, $initChunks=true) {
		if (!$target){
			$target = '/admin/' . get_class($this);
		}
		$formName = get_class($this) . '_addedit';
		$els = array();
		
		$form = new Form($formName, 'post', $target);
		$form->setConstants (array ('action' => @$_REQUEST['action'],
									'section' => @$_REQUEST['section'],
									'uniqid' => uniqid()));
		$form->addElement ('hidden', 'action');
		$form->addElement ('hidden', 'section');
		$form->addElement ('hidden', 'uniqid');
		
		foreach ($this->columns() as $column) {
			if ($column->noForm()) continue;
			$name = $column->name();
			$value = call_user_func(array($this, 'get'.Inflector::camelize($name)));
			// $value = &$this->get($name);
			$id = $this->quickformPrefix() . $name;
			$formValue = $column->toForm($value);
			if ($column->hidden()) {
				$el = $form->addElement("hidden", $id);
				$el->setValue ($formValue);
			} else if ($this->addElementTo($form, $id, $formValue)) {
				// Do nothing				
			} else {
				$el = $column->addElementTo(array(
						'form' => $form,
						'id' => $id,
						'value' => $formValue));
			}
			if ($column->required()) {
				$form->addRule($id, "Please enter the " . $column->label(), 'required', null, 'client');
			}
			$els[$name] = $el;
		}
		$this->getAddEditFormHook($form);
		if ($initChunks && $this->chunkable() && ($name = $this->getPageTemplate())) {
			$template = is_array ($name)
				? Template::getRevision('Module_' . $name[0], $name[1])
				: Template::getRevision('CMS', $name);
			$this->chunkManager->setTemplate($template);
			$this->chunkManager->insertFormFields($form);
		}
		
		$form->addElement('submit', $this->quickformPrefix() . 'submit', 'Submit');
		if ($form->isSubmitted() && isset($_REQUEST[$this->quickformPrefix() . 'submit']) && $form->validate()) {
			$uniqid = $form->exportValue('uniqid');
			if (@$_SESSION['form_uniqids'][$uniqid]) {
				$form->setProcessed();
				$form->setResubmit();
				return $form;
			}
			$_SESSION['form_uniqids'][$uniqid] = 'submitted';
			foreach ($this->columns() as $column) {
				if ($column->noForm() || $column->ignored()) continue;
				$name = $column->name();
				$value = $form->exportValue($this->quickformPrefix() . $name);
				$form->getElement($this->quickformPrefix() . $name)->setValue($value);
				$this->set($name, $column->fromForm($value, $els[$name]));
			}
			$this->getAddEditFormBeforeSaveHook($form);
			$this->save();
			if ($this->chunkManager) $this->chunkManager->saveFormFields($form, 'draft');
			$this->getAddEditFormAfterSaveHook($form);
			$form->setProcessed();
		}
		return $form;
	}
	private static function camel2getset($text) {
		// camel2getset('getThisVar') => array('get', this_var);
		$initial = substr ($text, 0, 3);
		switch ($initial) {
			case "get":
			case "set":
				$text = substr ($text, 3);
				$text = ucfirst(preg_replace('/([a-z])([A-Z])/', '\1 \2', $text));
				return array ($initial, implode ('_', array_map ('strtolower', explode (' ', $text))));
			default: return null;
		}
	}
	private static function apply ($func, $type, $value, $el = null) {
		$class = ('A' <= $type[0] and $type[0] <= 'Z')
			? "DBColumnClass"
			: DBColumn::getType($type);
		return call_user_func (array ($class, $func), $value, $el);
	}
	public static function     toDB($type, $value, $el=null) {return self::apply('toDB',     $type, $value, $el);}
	public static function   fromDB($type, $value) {return self::apply('fromDB',   $type, $value);}
	public static function   toForm($type, $value) {return self::apply('toForm',   $type, $value);}
	public static function fromForm($type, $value, $el=null) {return self::apply('fromForm', $type, $value, $el);}
	function getDraftForms() {
		if ($this->chunkManager && Chunk::hasDraft($this)) {
			global $smarty;
			$smarty->assign ('obj', $this);
			$smarty->assign ('id', $this->getId());
			return $smarty->fetch ('../../../templates/draft-actions.tpl'); // TODO:  FIX SO PATH CAN BE JUST draft-actions.tpl
		} else {
			return "";
		}
	}

	public function getObjectType() {
		return get_class($this);
	}
}
