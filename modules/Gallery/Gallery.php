<?php

class Module_Gallery extends Module {
	public function __construct() {
		$this->page = new Page();
		$this->page->with('PhotoGallery')
			->show(array(
				'Name' => 'name',
				'Active' => 'status',
			))
			->name('Photo Gallery')
			->on('addedit')->noAJAX()->action('PhotoGalleryImage');
			
			
		$this->page->with('PhotoGalleryImage')
			->show(array(
				'Title' => 'title',
			))
			->name('Photo Gallery Image')
			->link(array('photo_gallery_id', array('PhotoGallery', 'id')));
			
		$this->page->with('PhotoGallery');
	}
	
	public function getAdminInterface() {
		return $this->page->render();
	}
	
	public function getUserInterface($params = null) {
		$this->addJS('/modules/Gallery/js/lightbox.js');
		$this->addCSS('/modules/Gallery/css/lightbox.css');
		$this->addCSS('/modules/Gallery/css/gallery.css');
		
		if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
			$gallery = DBRow::make($_REQUEST['page'], 'PhotoGallery');
			$this->smarty->assign('curgallery', $gallery);
			$this->smarty->assign('galleries', $gallery->getSubGalleries());
			return $this->smarty->fetch('galleries.tpl');
		} else {
			$galleries = PhotoGallery::getAll('where parent_gallery_id=0');
			$this->smarty->assign('galleries', $galleries);
			return $this->smarty->fetch('galleries.tpl');
		}
	}
	
	public static function getLinkables($level = 0, $id = null){
		switch($level){
			case 1:
			default:
				$linkItems = PhotoGallery::getAll('where parent_gallery_id=0');
				foreach($linkItems as $linkItem){
					$linkables[$linkItem->get('id')] = $linkItem->get('name');
					$linkables[0] = "--Top Level Gallery--";
				}
				return $linkables;
		}
	}
	
	public function getLinkable($id){
		$page = PhotoGallery::make($id, 'PhotoGallery');
		if ($page->get('id')){
			return '/gallery/' . $page->get('id') . '-' . $page->get('name');
		}
		return '/gallery/';
	}
}
