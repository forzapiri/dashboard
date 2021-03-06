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


class Template extends DBRow {

	private static $revisionsQuery;
	private static $revisionQuery;
	private static $allTemplatesQuery=null;
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'module', 'Module'),
			DBColumn::make('text', 'path', 'Path'),
			DBColumn::make('longtext', 'data', 'Data'),
			'//timestamp',
			DBColumn::make('text', 'name', 'Name')
			);
		$table = parent::createTable("templates", __CLASS__, $cols);
		
		$sql = $table->loadColumnNames(); // This just returns a comma-separated list of those column names that are not delay loaded.
		self::$revisionQuery = new Query ("select $sql from templates where module=? and path=? order by timestamp desc limit 1", "ss");
		self::$revisionsQuery = new Query ("select $sql from templates where module=? and path=? order by timestamp desc", "ss");
		self::$allTemplatesQuery = new Query("select $sql from (select $sql from templates order by `timestamp` desc) templates group by path order by module, path");
		return $table; 
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
	
	public static function getRevision($module, $path) {
		$result = self::$revisionQuery->fetch($module, $path);
		if (!$result) trigger_error ("Template $path of $module does not exist");
		$result = Template::make($result);
		return $result;
	}
	
	public function getRevisions() {
		$results = self::$revisionsQuery->fetchAll($this->getModule(), $this->getPath());
		foreach ($results as &$result) {
			$result = Template::make($result);
		}
		return $results;
	}
	
	public function getModuleName() {
		if ($this->getModule() == 'CMS') {
			return 'CMS';
		}
		return substr($this->getModule(), 7);
	}
	
	public static function getAllTemplates($where = null) {
		$results = self::$allTemplatesQuery->fetchAll();
		foreach ($results as &$result) {
			$result = Template::make($result);
		}
		return $results;
	}
	
	public function toArray($where = null) {
		$array = array();
		foreach (self::getAllTemplates($where) as $s) {
			if (($where == null || $s->getModule() == $where) && $s->getName() != '') {
				$array[$s->getPath()] = $s->getName();
			}
		}
		return $array;
	}
}

DBRow::init('Template');
