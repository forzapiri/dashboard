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

class Group extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Group Name')
			);
		return parent::createTable("auth_groups", __CLASS__, $cols);
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
	function quickformPrefix() {return 'group_';}
	
	public function getCountMembers() {
		$sql = 'select count(id) as count from auth where `group`=' . $this->get('id');
		$members = Database::singleton()->query_fetch($sql);
		return $members['count'];
	}
	
	public static function toArray() {
		$groups = self::getAll();
		$array = array();
		foreach ($groups as $group) {
			$array[$group->getId()] = $group->getName();
		}
		return $array;
	}

}
DBRow::init('Group');
