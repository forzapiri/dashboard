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
		return new DBTable("photo_galleries", __CLASS__, $cols);
	}
	static function getAll($where = null) {return parent::getAll($where, __CLASS__);}
	function quickformPrefix() {return 'photo_gallery_';}
	
	public function getSubGalleries() {
		return self::getAll('where parent_gallery_id=' . $this->get('id'));
	}
	
	public function getGalleryImages() {
		return PhotoGalleryImage::getAll('where photo_gallery_id=' . $this->get('id'));
	}
	
	public function getFirstImage(){
		$images = PhotoGalleryImage::getAll('where photo_gallery_id=' . $this->get('id') . ' limit 1 ');
		if (!isset($images[0])){
			return false;
		}
		return $images[0]->get('file');
	}
}

DBRow::init('PhotoGallery');
