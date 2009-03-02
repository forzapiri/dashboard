<?php
/**
 * Blocks
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * DETAILED CLASS TITLE
 *
 * DETAILED DESCRIPTION OF THE CLASS
 * @package CMS
 * @subpackage Core
 */

class Block extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('text', 'title', 'Title'),
			DBColumn::make('tinymce', 'content', 'Content'),
			'timestamp',
			'//status',
			DBColumn::make('//integer', 'sort')
			);
		return new DBTable("blocks", __CLASS__, $cols);
	}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	function quickformPrefix() {return 'blocks_';}

	static function getAllBlocks ($status = null) {
		if($status == 'active'){
			return self::getAll("where status=1", '');
		} else {
			return self::getAll();
		}
	}
}
DBRow::init('Block');
