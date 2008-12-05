<?php

class Module_Content extends Module implements linkable {
	public function __construct() {
		parent::__construct();
		$dispatcher = &Event_Dispatcher::getInstance('ContentPage');
		$dispatcher->addNestedDispatcher(Event_Dispatcher::getInstance());
		
		$dispatcher->addObserver(array('ContentPage', 'checkForHome'), 'onPreDelete');
		
		$pagerev = &Event_Dispatcher::getInstance('ContentPageRevision');
		$pagerev->addNestedDispatcher(Event_Dispatcher::getInstance());
		
		$pagerev->addObserver(array('ContentPageRevision', 'disableOthers'), 'onToggle');
	}
	
	function getUserInterface() {
		include ('include/ContentPage.php');
		include ('include/ContentPageRevision.php');
		$pageid = ContentPage::keytoid($_REQUEST['page']);
		$revid = ContentPage::activeRev($pageid['id']);
		if(!is_null($revid)){
			$rev = new ContentPageRevision($revid['id']);
			$this->smarty->assign('content',$rev);
			$this->parentSmarty->templateOverride = 'db:' . $rev->getPageTemplate();
			$this->setPageTitle($rev->get('page_title'));
		} else {
			return $this->smarty->dispErr('404', &$this);
		}
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
			 ->pre($this->smarty->fetch('admin/pages.tpl'))
			 ->on('addedit')->action('ContentPageRevision');
			 
		$page->with('ContentPageRevision')
			 ->show(array(
			 	'Title' => 'page_title',
			 	'Created' => 'timestamp',
			 	'Published' => 'status'))
			 ->name('Content Page Revision')
			 ->link(array('parent', array('ContentPage', 'id')))
			 ->showCreate(false);
			 
		$page->with('ContentPage');
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
		$page = new ContentPage($id);
		return '/content/' . $page->get('url_key');
	}
}

?>
