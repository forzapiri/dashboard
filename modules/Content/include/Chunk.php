<?php
class Chunk extends DBRow {
	function createTable() {return parent::createTable("chunk", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllFor($obj) {
		$class = get_class($obj);
		$id = $obj->getId();
		return ($class && $id)
			? self::getAll("where parent_class='$class' and parent=$id")
			: array();
	}
	function getRawContent($active = true) {return $active ? $this->getActiveRevision()->getContent() : $this->getDraftRevision()->getContent();}
	function getContent($active = true) {return DBRow::fromDB($this->getType(), $this->getRawContent($active));}
}
DBRow::init('Chunk');
?>
