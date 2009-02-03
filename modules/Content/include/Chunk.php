<?php
class Chunk extends DBRow {
	function createTable() {return parent::createTable("chunk", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllFor($obj) {
		$class = get_class($obj);
		$id = $obj->getId();
		return ($class && $id) ? self::getAll("where parent_class='$class' and parent=$id") : array();
	}
	
	static function getAllContentFor($obj, $status = 'active') {
		$chunks = Chunk::getAllFor($obj);
		foreach ($chunks as &$chunk) {
			$type = $chunk->getType();
			$chunk = $chunk->getRevision($status);
			$chunk = DBRow::fromDB($type, $chunk->getContent());
		}
		return new ChunkList($chunks);
	}
	
	function getRevision ($status = 'active') {
		// This code not only gets the current revision, but also creates one if needed.
		if ($this->getName() && $this->getRole() && $this->getParent()) {
			$name = e($this->getName());
			$role = $this->getRole();
			$c = self::getAll("where role='$role' and name='$name' and (parent is null or parent=0)");
			if (!$c) { // Create the canonical Chunk with this (role, name) pair.
				$c = Chunk::make();
				$c->setRole($c);
				$c->setName($name);
				$c->save();
				$id = $c->getId();
			} else {
				$id = $c[0]->getId();
			}
		} else {
			$id = $this->getId();
		}
		switch ($status) {
		case 'active': $statusClause = "status='$status'"; break;
		case 'draft': $statusClause = "(status='draft' OR status='active') ORDER BY status DESC limit 1"; break;
		default: trigger_error ("Invalid status in getRevision: $status");
		}
		$all = ChunkRevision::getAll("where parent=$id and $statusClause");
		if ($all) {
			$rev= $all[0];
		} else {
			$rev = ChunkRevision::make();
			$rev->setParent($id);
			$rev->setStatus($status);
		}
		return $rev;
	}

	function getRawContent($status = 'active') {
		if (!$this->getRevision ($status)) {
			trigger_error ("Failed to get content");
			return "";
		}
		return $this->getRevision($status)->getContent();
	}
	function getContent($status = 'active') {return DBRow::fromDB($this->getType(), $this->getRawContent($status));}
}

class ChunkList { // Just so that the template doesn't need to pass in an iterating index
	private $list, $ptr=0;
	function __construct($list) {$this->list = $list;}
	function get($ignored_string) {return $this->list[$this->ptr++];}
}

DBRow::init('Chunk');
?>
