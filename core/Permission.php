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

class Permission extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('!select', 'key', 'Key', array('view' => 'View', 'addedit'=>'Add / Edit', 'delete' => 'Delete')),
			DBColumn::make('!text', 'name', 'Name'),
			DBColumn::make('text', 'description', 'Description'),
			DBColumn::make('!text', 'class', 'Class'),
			DBColumn::make('Group(name)', 'group_id', 'Group Name'),
			'//status'
			);
		return parent::createTable("permissions", __CLASS__, $cols);
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

	static private $warned = false;
	static function hasPerm($group, $class, $key) {
		if (SiteConfig::programmer() && $class=='Template') {
			$p = Permission::make();
			$p->setGroup($group);
			$p->setClass($class);
			$p->setKey($key);
			return array ($p);
		}
		return self::getAll('where group_id=? and class=? and `key`=? and status=1', 'iss',
							$group, $class, $key);
	}

	function quickformPrefix() {return 'permissions_';}
	
}
DBRow::init('Permission');
