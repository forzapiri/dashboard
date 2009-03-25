<?php

class Module_VideoGallery extends Module {
	public function __construct() {
		$this->page = new Page();
		$this->page->with('VideoGallery')
			->show(array(
				'Name' => 'name',
				'Active' => 'status',
			))
			->name('Video Gallery')
			->on('addedit')->noAJAX()->action('Video');
			
			
		$this->page->with('Video')
			->show(array(
				'Name' => 'name',
			))
			->name('Video')
			->link(array('video_gallery_id', array('VideoGallery', 'id')));
			
		$this->page->with('VideoGallery');
	}
	
	public function getAdminInterface() {
		return $this->page->render();
	}
	
	public function getUserInterface($params = null) {
		if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
			$gallery = DBRow::make($_REQUEST['page'], 'VideoGallery');
			$this->smarty->assign('gallery', $gallery);
			return $this->smarty->fetch('galleries.tpl');
		}
	}
	
	public static function getLinkables($level = 0, $id = null){
		switch($level){
			case 1:
			default:
				$linkItems = VideoGallery::getAll();
				foreach($linkItems as $linkItem){
					$linkables[$linkItem->get('id')] = $linkItem->get('name');
					$linkables[0] = "--Top Level Gallery--";
				}
				return $linkables;
		}
	}
	
	public function getLinkable($id){
		$page = VideoGallery::make($id, 'VideoGallery');
		if ($page->get('id')){
			require_once (SITE_ROOT . '/core/plugins/modifier.urlify.php');
			return '/videogallery/' . $page->get('id') . '-' . smarty_modifier_urlify($page->get('name'));
		}
		return '/videogallery/';
	}
}

?>