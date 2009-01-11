<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllContentFor($obj, $contentOnly = true) {
		$class = get_class($obj);
		$id = $obj->getId();
		if (!$id) return array();
		$sql = "select type,content from chunk c,chunk_revision r where active_revision_id=r.id and c.parent=$id and parent_class='$class' order by sort";
		$results = Database::singleton()->query_fetch_all($sql);
		$contents = array();
		foreach ($results as $result) {
			$type = $result['type'];
			$content = DBRow::fromDB($type, $result['content']);
			$contents[] = $contentOnly ? $content : array ('value' => $content, 'class' => $class);
		}
		return $contents;
	}
  }
DBRow::init('ChunkRevision');
?>
