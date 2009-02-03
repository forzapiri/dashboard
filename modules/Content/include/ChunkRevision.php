<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllContentFor($obj, $status = 'active') {
		$class = get_class($obj);
		$id = $obj->getId();
		if (!$id) return array();
		// Tried using prepared statement.  For some reason didn't work.
		$sql = "select type,content from chunk c,chunk_revision r where r.status='$status' and r.parent = c.id and c.parent=$id and parent_class='$class' order by sort";
		$results = Database::singleton()->query_fetch_all($sql);
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

	static function getChunkFormField ($class, $parent, $status = 'active') {
		$sql = "select type,content from chunk c,chunk_revision r where r.status='$status' and c.parent_class=? and c.parent=?";
		$query = new Query ($sql, 'si');
		$result = $query->fetch ($class, $parent);
		return self::getRevisionFormField($result);
	}

	static function getNamedChunkFormField ($role, $name, $status = 'active') {
		$sql = "select type,content from chunk c,chunk_revision r where r.status='$status' and role=? and c.parent is null and name=?";
		$query = new Query ($sql, 'ss');
		$result = $query->fetch ($role, $name);
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
