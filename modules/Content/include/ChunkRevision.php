<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	// NEED TO PAY ATTENTION TO NAMED CONTENT HERE!!  AND TO REVISIONS.  MAKE MULTIPLE DB CALLS AND GO CHUNK BY CHUNK  ???
	private static $q1a;
	private static $q1b;

	static private function getRevisionFormField($chunk, $status) {
		if (!$chunk) return null;
		$type = $chunk->getType();
		$c = $chunk->getContent($status);
		return DBRow::toForm($type, $c);
	}

	static function getChunkFormField ($class, $parent, $sort, $status = 'draft') {
		$c = Chunk::getAll("where parent_class='$class' and parent=$parent and sort=$sort");
		return $c ? self::getRevisionFormField($c[0], $status) : "";
	}

	static function getNamedChunkFormField ($role, $name, $status = 'draft') {
		$c = Chunk::getAll("where role='$role' and name='$name' and (parent is null or parent=0)");
		return self::getRevisionFormField($c[0], $status);
	}
}
	
DBRow::init('ChunkRevision');
?>
