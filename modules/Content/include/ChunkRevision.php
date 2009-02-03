<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	// NEED TO PAY ATTENTION TO NAMED CONTENT HERE!!  AND TO REVISIONS.  MAKE MULTIPLE DB CALLS AND GO CHUNK BY CHUNK  ???
	private static $q1a;
	private static $q1b;

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
	
DBRow::init('ChunkRevision');
?>
