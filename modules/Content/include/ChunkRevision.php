<?php
class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllContentFor($obj, $active = true) {
		$class = get_class($obj);
		$id = $obj->getId();
		if (!$id) return array();
		$col = ($active ? "active" : "draft") . "_revision_id";
		$sql = "select type,content from chunk c,chunk_revision r where $col=r.id and c.parent=$id and parent_class='$class' order by sort";
		$results = Database::singleton()->query_fetch_all($sql);
		$contents = array();
		foreach ($results as $result) {
			$type = $result['type'];
			$contents[] = DBRow::fromDB($type, $result['content']);
		}
		return new ChunkList($contents);
	}
}
class ChunkList {
	private $list, $ptr=0;
	function __construct($list) {$this->list = $list;}
	function get($ignored_string) {return $this->list[$this->ptr++];}
}
	
DBRow::init('ChunkRevision');
?>
