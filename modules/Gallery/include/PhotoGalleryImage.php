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
	static function getAll($where = null) {return parent::getAll($where, __CLASS__);}
	function quickformPrefix() {return 'photo_gallery_image_';}

}

DBRow::init('PhotoGalleryImage');
