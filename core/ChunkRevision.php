<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

class ChunkRevision extends DBRow {
	function createTable() {return parent::createTable("chunk_revision", __CLASS__);}
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

	static private function getRevisionFormField($chunk, $status) {
		if (!$chunk) return null;
		$type = $chunk->getType();
		$c = $chunk->getContent($status, false);
		$content = DBRow::toForm($type, $c);
		return array ('content' => $content, 'i' => $chunk->getCount($status), 'n' => $chunk->countRevisions());
	}

	static function getChunkFormField ($class, $parentId, $sort, $status /* or count */) {
		$c = Chunk::getAll("where parent_class=? and parent=? and sort=?", 'sii', $class, $parentId, $sort);
		return $c ? self::getRevisionFormField($c[0], $status) : "";
	}

	static function getNamedChunkFormField ($role, $name, $status = 'draft') {
		$c = Chunk::getAll("where role=? and name=? and (parent is null or parent=0)", 'ss', $role, $name);
		return self::getRevisionFormField($c[0], $status);
	}
}
	
DBRow::init('ChunkRevision');
