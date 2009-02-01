<?php

class Module_Content extends Module implements linkable {
	public function __construct() {
		parent::__construct();
		$dispatcher = &Event_Dispatcher::getInstance('ContentPage');
		$dispatcher->addNestedDispatcher(Event_Dispatcher::getInstance());
		
		$dispatcher->addObserver(array('ContentPage', 'checkForHome'), 'onPreDelete');
	}
	
	function getUserInterface() {
		$pageid = ContentPage::keytoid($_REQUEST['page']);
		$pageid = $pageid['id'];
		$page = ContentPage::make($pageid);
		$this->smarty->assign('content',$page);
		$this->parentSmarty->templateOverride = $page->getSmartyResource();
		$this->setPageTitle("PAGE TITLE STUB");
		/* CHUNKS */
		$this->smarty->assign ('chunks', ChunkRevision::getAllContentFor($page));
		return $this->smarty->fetch('db:content.tpl');	 
	}
	
	function getAdminInterface() {
		$this->addJS('/modules/Content/js/admin/handleHome.js');
		$page = new Page();
		$page->with('ContentPage')
			 ->show(array(
			 	'Name' => 'name',
			 	'Created' => 'timestamp',
			 	'Published' => 'status'))
			 ->name('Content Page')
			 ->pre($this->smarty->fetch('admin/pages.tpl'));
		return $page->render();
	}
	
	public static function getLinkables($level = 0, $id = null){
		switch($level){
			case 1:
			default:
				$linkItems = ContentPage::getAll("where status = '1'");
				foreach($linkItems as $linkItem){
					$linkables[$linkItem->get('id')] = $linkItem->get('name');
				}
				return $linkables;
		}
	}
	
	public function getLinkable($id){
		$page = ContentPage::make($id);
		return '/content/' . $page->get('url_key');
	}
}

?>
