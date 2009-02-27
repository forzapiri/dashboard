<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return parent::getAll($where, __CLASS__);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static private function getRevisionFormField($chunk, $status) {
		if (!$chunk) return null;
		$type = $chunk->getType();
		$c = $chunk->getContent($status, false);
		$content = DBRow::toForm($type, $c);
		return array ('content' => $content, 'i' => $chunk->getCount($status), 'n' => $chunk->countRevisions());
	}

	static function getChunkFormField ($class, $parent, $sort, $status /* or count */) {
		$c = Chunk::getAll("where parent_class='$class' and parent=$parent and sort=$sort");
		return $c ? self::getRevisionFormField($c[0], $status) : "";
	}

	static function getNamedChunkFormField ($role, $name, $status = 'draft') {
		$c = Chunk::getAll("where role='$role' and name='$name' and (parent is null or parent=0)");
		return self::getRevisionFormField($c[0], $status);
	}
}
	
DBRow::init('ChunkRevision');
