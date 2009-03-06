<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function getCount() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static private function getRevisionFormField($chunk, $status) {
		if (!$chunk) return null;
		$type = $chunk->getType();
		$c = $chunk->getContent($status, false);
		$content = DBRow::toForm($type, $c);
		return array ('content' => $content, 'i' => $chunk->getCount($status), 'n' => $chunk->countRevisions());
	}

	static function getChunkFormField ($class, $parentId, $sort, $status /* or count */) {
		$c = Chunk::getAll("where parent_class=? and parent=? and sort=?", 'sii', $class, $parentId, $sort);
		return $c ? self::getRevisionFormField($c[0], $status) : "";
	}

	static function getNamedChunkFormField ($role, $name, $status = 'draft') {
		$c = Chunk::getAll("where role=? and name=? and (parent is null or parent=0)", 'ss', $role, $name);
		return self::getRevisionFormField($c[0], $status);
	}
}
	
DBRow::init('ChunkRevision');
