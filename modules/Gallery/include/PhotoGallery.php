<?php

class PhotoGallery extends DBRow {
	
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Photo Gallery Name'),
			DBColumn::make('PhotoGallery(name)', 'parent_gallery_id', 'Parent Photo Gallery'),
			DBColumn::make('File(description)', 'thumbnail_id', 'Thumbnail Image'),
			DBColumn::make('textarea', 'description', 'Description', array ('rows' => 16, 'cols' => 50)),
			'timestamp',
			'//status',
			);
		return parent::createTable("photo_galleries", __CLASS__, $cols);
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
	function quickformPrefix() {return 'photo_gallery_';}
	
	public function getSubGalleries() {
		return self::getAll('where parent_gallery_id=?', 'i', $this->get('id'));
	}
	
	public function getGalleryImages() {
		return PhotoGalleryImage::getAll('where photo_gallery_id=?', 'i', $this->get('id'));
	}
	
	public function getFirstImage(){
		$images = PhotoGalleryImage::getAll('where photo_gallery_id=? limit 1 ' , 'i', $this->get('id'));
		if (!isset($images[0])){
			return false;
		}
		return $images[0]->get('file');
	}
}

DBRow::init('PhotoGallery');
