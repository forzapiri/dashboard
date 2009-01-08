<?php

class User extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'username', 'Username'),
			DBColumn::make('password', 'password', 'Password'),
			DBColumn::make('//text', 'salt', 'Salt'),
			DBColumn::make('select', 'group', 'Group', Group::toArray()),
			DBColumn::make('timestamp', 'timestamp', 'Timestamp'),
			DBColumn::make('text', 'name', 'First Name'),
			DBColumn::make('text', 'last_name', 'Last Name'),
			DBColumn::make('!email', 'email', 'Email'),
			DBColumn::make('status', 'status', 'Status'),
			);
		return new DBTable("auth", __CLASS__, $cols);
	}
	static function make($id = null) {return parent::make(__CLASS__, $id);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	function quickformPrefix() {return 'user_';}
	
	public function hasPerm($class, $key) {
		$p = Permission::hasPerm($this->getGroup(), $class, $key);
		return $p;
	}
	
	public function getAddEditForm($target = null) {
		$old = $this->get('password');
		$form = parent::getAddEditForm($target);
		$el =& $form->getElement($this->quickformPrefix() . 'password');
		$new = $el->getValue();
		$el->setValue(null);
		if ($form->isProcessed() && ($_REQUEST[$this->quickformPrefix() . 'password'] != '' && $new != '' && $new != null)) {
			$salt = uniqid('norexcms', true);
			$this->set('salt', $salt);
			$this->set('password', (md5($_REQUEST[$this->quickformPrefix() . 'password'] . md5($salt))));
			$this->save();
		} else if ($form->isProcessed()) {
			$this->set('password', $old);
			$this->save();
		}
		return $form;
	}
	
	public function toArray() {
		$array = array();
		foreach (self::getAll() as $s) {
			$array[$s->getId()] = $s->getName() . ' ' . $s->getLastName() . ' (' . $s->getUsername() . ')';
		}
		return $array;
	}

}
DBRow::init('User');

?>