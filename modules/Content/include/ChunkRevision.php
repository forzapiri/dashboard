<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	private static $q1;
	static function getAllContentFor($obj, $status = 'active') {
		if (!self::$q1) self::$q1 = new Query ("select type,content from chunk c,chunk_revision r where r.status=? and r.parent = c.id and c.parent=? and parent_class=? order by sort", 'sis');
		$class = get_class($obj);
		$id = $obj->getId();
		if (!$id) return array();
		$results = self::$q1->fetchAll($status, $id, $class);
		$contents = array();
		foreach ($results as $result) {
			$contents[] = DBRow::fromDB($result['type'], $result['content']);
		}
		return new ChunkList($contents);
	}

	static private function getRevisionFormField($result) {
		if (!$result) return null;
		$type = $result['type'];
		$result = DBRow::fromDB($type, $result['content']);
		$result = DBRow::toForm($type, $result);
		return $result;
	}

	private static $q2 = null;
	static function getChunkFormField ($class, $parent, $status = 'active') {
		if (!self::$q2) self::$q2 = new Query ("select type,content from chunk c,chunk_revision r where r.status='$status' and c.parent_class=? and c.parent=?",'si');
		$result = self::$q2->fetch ($class, $parent);
		return self::getRevisionFormField($result);
	}

	private static $q3 = null;
	static function getNamedChunkFormField ($role, $name, $status = 'active') {
		if (!self::$q3) self::$q3 =  new Query ("select type,content from chunk c,chunk_revision r where r.status='$status' and role=? and c.parent is null and name=?", 'ss');
		$result = self::$q3->fetch ($role, $name);
		return self::getRevisionFormField($result);
	}
}
class ChunkList {
	private $list, $ptr=0;
	function __construct($list) {$this->list = $list;}
	function get($ignored_string) {return $this->list[$this->ptr++];}
}
	
DBRow::init('ChunkRevision');
?>
