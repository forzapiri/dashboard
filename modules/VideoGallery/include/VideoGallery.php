<?php

class VideoGallery extends DBRow {
	
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Video Gallery Name'),
			DBColumn::make('textarea', 'description', 'Description', array ('rows' => 16, 'cols' => 50)),
			'timestamp',
			'//status',
			);
		return parent::createTable("video_galleries", __CLASS__, $cols);
	}
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
	function quickformPrefix() {return 'video_gallery_';}
	
	public function getGalleryVideos() {
		return Video::getAll('where video_gallery_id=?', 'i', $this->get('id'));
	}
}

DBRow::init('VideoGallery');