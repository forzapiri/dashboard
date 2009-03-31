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

abstract class DBColumn {
	/*
	 * Definitions:
	 *  type:  The type is associated with rules for dealing with the column entry in a DB and forms
	 *  name:  The column heading in the db; by default, this equals the Quickform fieldname.
	 * 			If you need name resolution, overload the DBTable's quickformPrefix().
	 *  label: The text associated with a Quickform entry.
	 *  modifier:  A prefix or suffix to the type 'email!' required; 'email?' hidden; '//email' ignored  
	 */
	private $_name;
	private $_label;
	private $_modifier;
	private $_options;
	private $loadQuery; // USING mysqli PREPARED STATEMENT
	private $loadSQL;   // USING A PLAIN SQL CALL (APPEND id)
	private $modifierCodes = array( null => '',
					'' => '',
					'?' => 'hidden',
					'!' => 'required',
					'//' => 'no form',
					'hidden' => 'hidden',
					'required' => 'required',
					'ignored' => 'ignored',
					'no db column' => 'ignored',
					'no form' => 'no form');

	protected abstract function type();
	function name() {return $this->_name;}
	function label() {return $this->_label;}
	function getLabel() {return $this->_label;}
	function setLabel($label) {$this->_label = $label;}
	function options() {return $this->_options;}

	function hidden() {return $this->_modifier == 'hidden';}
	function required() {return $this->_modifier == 'required';}
	function noForm() {return $this->_modifier == 'no form';}
	function ignored() {return $this->_modifier == 'ignored';}
	function delayLoad() {return $this->prepareCode() == 'b';}
	
   /**
	*  Mssqli prepared statement type.
	* 
	* Possible return values of prepareCode:   
	* i corresponding variable has type integer
	* d corresponding variable has type double
	* s corresponding variable has type string
	* b corresponding variable is a blob and will be sent in packets 
	*/
	function prepareCode() {return 's';}
	/* Use DBColumn::make() to construct a column. */
	function DBColumn($name=null, $label = null, $modifier = "", $options = null) {
		$this->_label = $label ? $label : ucwords(str_replace('_', ' ', $this->type())); 
		$this->_name = $name ? $name : $this->type();
		$this->_modifier = $this->modifierCodes[$modifier];
		$this->_options = $options;
	}

	function display($obj) {return $obj;}
	static function toDB($obj) {return $obj;}
	static function fromDB($obj) {return $obj;}
	static function toForm($obj) {return $obj;}
	static function fromForm($obj) {return $obj;}
	function suggestedMysql() {return "varchar(256)";}
	function addElementTo ($args) {
		$value = null;
		$label = $this->label();
		extract($args);
		$options = $this->options();
		if (1 == count($options)	&& is_string(@$options[0]) && (@$options[0] > 0)) {
			$options = array ('size' => $options[0]);
		}
		$el = $form->addElement ('text', $id, $label, $options);
		$el->setValue($value);
		return $el;
	}

	function setLoadQuery($query) {$this->loadQuery = $query;}
	function setLoadSQL($sql) {$this->loadSQL = $sql;}
	function load($id) {
		// $result = $this->loadQuery->fetch($id);
		$result = Database::singleton()->query_fetch ($this->loadSQL . $id);
		return $result[$this->name()];
	}

	static function make($fullType, $name=null, $label=null, $options = null, $modifier = null) {
		if (preg_match ('/^()([a-zA-Z_]+)(\(.*\))?:([a-zA-Z_]+)/', $fullType, $matches)) {
			// Do nothing.  Type name is of the form 'text:ignore'
		} else if (preg_match ('/^([!?\/]*)([a-zA-Z_]+)(\(.*\))?([!?\/]*)/', $fullType, $matches)) {
			// Do nothing.  Type name is of the form '//text'
		} else	{
			error_log ("Mal-formed type name $fullType");
			die();
		}
		$type = $matches[2];
		if (!$modifier) {$modifier = $matches[1] . $matches[4];}
		if (!$options) {
			$options = trim($matches[3], '()');
			$options = array_map('trim', explode(",", $options));
		}
		if ('A' <= $type[0] and $type[0] <= 'Z') {
			return new DBColumnClass($type, $name, $label, $modifier, $options);
		}
		$class = @self::$types[$type];
		if (!$class) trigger_error ("Type '$type' is not registered");
		return new $class($name, $label, $modifier, $options);
	}
	static public $types = array();
	static public function getType($type) {return self::$types[$type];}
	static function register($column) {
		$type = (is_object ($column)) ? $column : new $column;
		self::$types[$type->type()] = $column;
	}
	static function getTypes() {
		$t = array_keys(self::$types);
		return array_combine($t,$t);
	}
	static function registerClasses() {
		$classes = get_declared_classes();
		foreach ($classes as $class) {
			if (!is_subclass_of ($class, __CLASS__) || $class == 'DBColumnClass') continue;
			$r = new ReflectionClass($class);
			if ($r->isAbstract()) continue;
			self::register($class);
		}
	}
	
	public function __toString($item,$key) {
		return $item->get($key);
	}
}
include_once 'DBColumns.php';

class DBColumnClass extends DBColumnId { // A column type for an id, where the intended object is new Typename ($id);
	function type() {return $this->class;}
	// function delayLoad() {return true;} // TODO:  Make these delay load; otherwise circularity problems
	static private $classes = array();
	public $class;
	function DBColumnClass($class, $name=null, $label = null, $modifier = "", $options = null) {
		$this->class = $class;
		parent::__construct($name, $label, $modifier, $options);
	}
	function getValues() {
		return call_user_func(array($this->class, 'getAll'));
	}
	function addElementTo($args) {
		$value = null;
		$label = $this->label();
		$options = array();
		extract ($args);
		$dummy = DBRow::make(null, $this->class);
		$rows = $dummy->table()->getAllRows();
		$col = $this->options();
		$col = $col ? $col[0] : 'id';
		$col = $col ? $col : 'id';
		if ($this->class == 'MenuType') {
			$col = 'name';
			array_shift($rows);
		} else {
			$options[0] = '-- NONE --';
			$options['new'] = '-- Create New --';
		}
		foreach ($rows as $row) {
			$options[$row->get('id')] = $row->get($col);
		}
		$el = $form->addElement ('select', $id, $label, $options, array('onchange' => 'ui.createHandler(this, \'' . $this->class . '\')'));
		$el->setValue($value);
		return $el;
	}
}
