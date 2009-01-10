<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllContentFor($obj) {
		$class = get_class($obj);
		$id = $obj->getId();
		$sql = "select type,content from chunk,chunk_revision r where chunk_revision_id=r.id and parent=$id and parent_class='$class'";
		$results = Database::singleton()->query_fetch_all($sql);
		foreach ($results as $result) {
			$type = $result['type'];
			$content = $result['content'];
			$class = DBColumn::getType($type);
			$contents[] = call_user_func (array($class, 'fromDB'), $content);
		}
		return $contents;
	}
  }
DBRow::init('ChunkRevision');
?>
