<?php
/**
 * Templates
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * DETAILED CLASS TITLE
 * 
 * DETAILED DESCRIPTION OF THE CLASS
 * @package CMS
 * @subpackage Core
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
		$table = new DBTable("templates", __CLASS__, $cols);
		
		$sql = $table->loadColumnNames(); // This just returns a comma-separated list of those column names that are not delay loaded.
		self::$revisionQuery = new Query ("select $sql from templates where module=? and path=? order by timestamp desc limit 1", "ss");
		self::$revisionsQuery = new Query ("select $sql from templates where module=? and path=? order by timestamp desc", "ss");
		self::$allTemplatesQuery = new Query("select $sql from (select $sql from templates order by `timestamp` desc) b group by path order by module, path");
		return $table; 
	}
	
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	
	public static function getRevision($module, $path) {
		$result = self::$revisionQuery->fetch($module, $path);
		$result = new Template($result);
		return $result;
	}
	
	public function getRevisions() {
		$results = self::$revisionsQuery->fetchAll($this->getModule(), $this->getPath());
		foreach ($results as &$result) {
			$result = new Template($result);
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
			$result = new Template($result);
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

?>