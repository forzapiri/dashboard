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
		if ($this->getName() && $this->getRole() && $this->getParent()) {
			$name = e($this->getName());
			$role = $this->getRole();
			$r = self::getAll("where role='$role' and name='$name' and (parent is null or parent=0)");
			if (!$r) { // Create the canonical Chunk with this (role, name) pair.
				$r = Chunk::make();
				$r->setRole($role);
				$r->setName($name);
				$r->save();
				$id = $r->getId();
			} else {
				$id = $r[0]->getId();
			}
		} else {
			$id = $this->getId();
		}
		$all = ChunkRevision::getAll("where parent=$id and status='$status'");
		if (!$all && $status == 'draft') // If there is no draft version, return the active one.
			$all = ChunkRevision::getAll("where parent=$id and status='active'");
		return $all ? $all[0] : $all;
	}
	function getRawContent($status = 'active') {
		if (!$this->getRevision ($status)) {
			var_log ($status);
			var_log ($this);
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
