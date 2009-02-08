<?php
  // Note that when a getter asks for the "draft", if no "draft" exists, we return the active version.

class Chunk extends DBRow {
	function createTable() {return parent::createTable("chunk", __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllFor($obj) {
		$class = get_class($obj);
		$id = $obj->getId();
		return ($class && $id) ? self::getAll("where parent_class='$class' and parent=$id") : array();
	}

	static function revertDrafts($obj) {
		foreach (self::getAllFor($obj) as $chunk) $chunk->revert();
	}
	function revert() {
		$draft = $this->getRevision('draft');
		if ($draft->getStatus() == 'draft') {
			$draft->setStatus('inactive');
			$draft->save();
		}
	}

	static function makeDraftActive($obj) {
		foreach (self::getAllFor($obj) as $chunk) $chunk->activate();
	}
	function activate() {
		$draft = $this->getRevision('draft');
		if ($draft->getStatus() == 'draft') {
			$active = $this->getRevision('active', false);
			if ($active && $active->getStatus() == 'active') {
				$active->setStatus('inactive');
				$active->save();
			}
			$draft->setStatus('active');
			$draft->save();
		}
	}
	
	private static $hasDraftFlag;
	static function hasDraft($obj) {
		self::getAllContentFor($obj, 'draft');
		return self::$hasDraftFlag;
	}

	static function getAllContentFor($obj, $status) {
		self::$hasDraftFlag = false;
		$chunks = Chunk::getAllFor($obj);
		foreach ($chunks as &$chunk) { // Converts Chunk -> rev -> content
			$type = $chunk->getType();
			$chunk = $chunk->getRevision($status);
			if ($chunk->getStatus() == 'draft') self::$hasDraftFlag = true;
			$chunk = DBRow::fromDB($type, $chunk->getContent());
		}
		return new ChunkList($chunks);
	}

	function getActualChunk() { // If this is a roled, named chunk returns the canonical version
		if (!($this->getName() && $this->getRole() && $this->getParent())) return $this;
		$name = e($this->getName());
		$role = $this->getRole();
		$c = self::getAll("where role='$role' and name='$name' and (parent is null or parent=0)");
		if (!$c) { // Create the canonical Chunk with this (role, name) pair.
			$c = Chunk::make();
			$c->setRole($role);
			$c->setName($this->getName());
			$c->setType($this->getType());
			$c->save();
			return $c;
		} else {
			return $c[0];
		}
	}
	
	function getRevision ($status, $create = true) {
		// This code not only gets the current revision, but also creates one if needed.
		$c = $this->getActualChunk();
		var_log ($c);
		$id = $c->getId();
		switch ($status) {
		case 'active': $statusClause = "status='$status'"; break;
		case 'draft': $statusClause = "(status='draft' OR status='active') ORDER BY status DESC limit 1"; break;
		default: trigger_error ("Invalid status in getRevision: $status");
		}
		$all = ChunkRevision::getAll("where parent=$id and $statusClause");
		if ($all) {
			$rev= $all[0];
		} else {
			if (!$create) return null;
			$rev = ChunkRevision::make();
			$rev->setParent($id);
			$rev->setStatus($status);
			$rev->setCount(0);
		}
		return $rev;
	}

	function getRawContent($status) {return $this->getRevision($status)->getContent();}
	function getCount($status) {return $this->getRevision($status)->getCount();}
	function getContent($status) {return DBRow::fromDB($this->getType(), $this->getRawContent($status));}

	static $countQuery = null;
	function countRevisions() {
		if (!self::$countQuery) self::$countQuery = new Query ("select count(*) as count from chunk_revision where parent=?", 'i');
		$c = $this->getActualChunk();
		$id = $c->getId();
		$sql = "d";
		$result = self::$countQuery->fetch($c->getId());
		return $result['count'];
	}
}

class ChunkList { // Just so that the template doesn't need to pass in an iterating index
	private $list, $ptr=0;
	function __construct($list) {$this->list = $list;}
	function get($ignored_string) {return $this->list[$this->ptr++];}
}

DBRow::init('Chunk');
?>
