<?php

class Video extends DBRow {
	
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Video Name'),
			DBColumn::make('textarea', 'description', 'Description', array ('rows' => 16, 'cols' => 50)),
			DBColumn::make('text', 'embed_code', 'Embed Code'),
			DBColumn::make('VideoGallery(name)', 'video_gallery_id', 'Parent Gallery'),
			);
		return parent::createTable("videos", __CLASS__, $cols);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}
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
	function quickformPrefix() {return 'video_';}

}

DBRow::init('Video');
