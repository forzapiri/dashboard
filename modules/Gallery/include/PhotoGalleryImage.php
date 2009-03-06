<?php

class PhotoGalleryImage extends DBRow {
	
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'title', 'Image Title'),
			DBColumn::make('File(description)', 'file_id', 'Image'),
			DBColumn::make('PhotoGallery(name)', 'photo_gallery_id', 'Parent Photo Gallery'),
			);
		return new DBTable("photo_gallery_images", __CLASS__, $cols);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function getCount() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}
	function quickformPrefix() {return 'photo_gallery_image_';}

}

DBRow::init('PhotoGalleryImage');
