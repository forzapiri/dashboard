<?php
  // Note that when a getter asks for the "draft", if no "draft" exists, we return the active version.

class Chunk extends DBRow {
	function createTable() {return parent::createTable("chunk", __CLASS__);}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function countAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	static function getAllFor($obj, $id = null) { // If $obj is a class name, $id is the object's id
		if ($id) {
			$class = $obj;
		} else {
			$class = get_class($obj);
			$id = $obj->getId();
		}
		return ($class && $id) ? self::getAll("where parent_class=? and parent=?", 'si', $class, $id) : array();
	}

	static function revertDrafts($class, $id) {
		foreach (self::getAllFor($class, $id) as $chunk) $chunk->revert();
	}
	function revert() {
		$draft = $this->getRevision('draft');
		if ($draft->getStatus() == 'draft') {
			$draft->setStatus('inactive');
			$draft->save();
		}
	}

	static function makeDraftActive($class, $id) {
		foreach (self::getAllFor($class, $id) as $chunk) $chunk->activate();
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
			$rev = $chunk->getRevision($status);
			if ($rev->getStatus() == 'draft') self::$hasDraftFlag = true;
			$chunk = DBRow::fromDB($type, $rev->getContent());
		}
		return new ChunkList($chunks);
	}

	function getActualChunk() { // If this is a roled, named chunk returns the canonical version
		if (!($this->getName() && $this->getRole() && $this->getParent())) return $this;
		$name = e($this->getName());
		$role = $this->getRole();
		$c = self::getAll("where role=? and name=? and (parent is null or parent=0)", 'ss', $role, $name);
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
	
	function getRevision ($statusORcount, $create = true, $follow = true) {
		// This code not only gets the current revision, but also creates one if needed.
		$c = $follow ? $this->getActualChunk() : $this;
		$id = $c->getId();
		$count = (integer) $statusORcount;
		switch ($statusORcount) {
		case 'active': $statusClause = "status='$statusORcount'"; break;
		case 'draft': $statusClause = "(status='draft' OR status='active') ORDER BY status DESC limit 1"; break;
		default:
			if (!$count) trigger_error ("Invalid status in getRevision: $statusORcount");
			$statusClause = "count=$count";
			$draft = ChunkRevision::getAll("where status='draft'", '');
			if ($draft) { // RESET PREVIOUS draft TO inactive
				$draft = $draft[0];
				$draft->setStatus('inactive');
				$draft->save();
			}
		}
		$all = ChunkRevision::getAll("where parent=? and $statusClause", 'i', $id);
		if ($all) {
			$rev= $all[0];
		} else {
			if (!$create) return null;
			$rev = ChunkRevision::make();
			$rev->setParent($id);
			$rev->setCount(0);
		}
		if ($rev->getStatus() == 'inactive') {
			$rev->setStatus('draft');
			$rev->save();
		}
		return $rev;
	}

	function getRawContent($status, $follow = true) {return $this->getRevision($status, true, $follow)->getContent();}
	function getCount($status, $follow = true) {return $this->getRevision($status, true, $follow)->getCount();}
	function getContent($status, $follow = true) {return DBRow::fromDB($this->getType(), $this->getRawContent($status, $follow));}

	static $countQuery = null;
	function countRevisions($follow = true) { // $follow means use canonical chunk of appropriate
		if (!self::$countQuery) self::$countQuery = new Query ("select count(*) as count from chunk_revision where parent=?", 'i');
		$c = $follow ? $this->getActualChunk() : $this;
		$id = $c->getId();
		$sql = "d";
		$result = self::$countQuery->fetch($c->getId());
		return $result['count'];
	}

	static function loadChunk() { // Load the chunk from $_REQUEST and update draft
		// CHUNKS: Response to AJAX request only.
		$role = e(@$_REQUEST['role']);
		$name = e(@$_REQUEST['name']);
		$parent_class = e(@$_REQUEST['section']);
		$parent = (int) @$_REQUEST['id'];
		$sort = (int) @$_REQUEST['sort'];
		$count = (int) @$_REQUEST['i'];
		$status = $count ? $count : 'draft';
		if ($role && $name) $result = ChunkRevision::getNamedChunkFormField($role, $name, $status);
		else if ($parent_class && $parent) $result = ChunkRevision::getChunkFormField ($parent_class, $parent, $sort, $status);
		else trigger_error ('Bad AJAX request for loadChunk');
		return json_encode ($result);
	}
}

class ChunkList { // Just so that the template doesn't need to pass in an iterating index
	private $list, $ptr=0;
	function __construct($list) {$this->list = $list;}
	function get($ignored_string) {return $this->list[$this->ptr++];}
}

DBRow::init('Chunk');
