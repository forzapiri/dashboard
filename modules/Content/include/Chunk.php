<?php
class Chunk extends DBRow {
	function createTable() {return parent::createTable("chunk", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	private $newName = false;
	static function getAllFor($obj) {
		$class = get_class($obj);
		$id = $obj->getId();
		return ($class && $id)
			? self::getAll("where parent_class='$class' and parent=$id")
			: array();
	}
	function getRevision ($status = 'active') {
		var_log ('START');
		if ($this->getName() && $this->getRole() && $this->getParent()) {
			var_log ('A');
			$name = e($this->getName());
			$role = $this->getRole();
			$r = self::getAll("where role='$role' and name='$name' and (parent is null or parent=0)");
			if (!$r) { // Create the canonical Chunk with this (role, name) pair.
				$r = new Chunk();
				$r->setRole($rule);
				$r->setName($name);
				$r->save();
				$id = $r->getId();
			} else {
				var_log ('B');
				$id = $r[0]->getId();
			}
		} else {
			var_log ('C');
			$id = $this->getId();
		}
		var_log ($id, 'ID');
		$all = ChunkRevision::getAll("where parent=$id and status='$status'");
		var_log (!!$all);
		if (!$all && $status == 'draft') // If there is no draft version, return the active one.
			$all = ChunkRevision::getAll("where parent=$id and status='active'");
		return $all ? $all[0] : $all;
	}
	function getRawContent($status = 'active') {
		if (!$this->getRevision ($status)) {
			var_log ($this);
			var_log ($status);
			trigger_error ("Failed to get content");
			return "";
		}
		return $this->getRevision($status)->getContent();
	}
	function getContent($status = 'active') {return DBRow::fromDB($this->getType(), $this->getRawContent($status));}
	function setNewName($newName = true) {$this->newName = $newName;}
	function newName() {return $this->new;}
}
DBRow::init('Chunk');
?>
