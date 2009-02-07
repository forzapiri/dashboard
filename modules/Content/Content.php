<?php

class Module_Content extends Module implements linkable {
	
	public $icon = '/modules/Content/images/page_edit.png';
	
	public function __construct() {
		parent::__construct();
		$dispatcher = &Event_Dispatcher::getInstance('ContentPage');
		$dispatcher->addNestedDispatcher(Event_Dispatcher::getInstance());
		
		$dispatcher->addObserver(array('ContentPage', 'checkForHome'), 'onPreDelete');
		
		$pagerev = &Event_Dispatcher::getInstance('ContentPageRevision');
		$pagerev->addNestedDispatcher(Event_Dispatcher::getInstance());
		
		$pagerev->addObserver(array('ContentPageRevision', 'disableOthers'), 'onToggle');
		
		$this->page = new Page();
		$this->page->with('ContentPage')
			 ->show(array(
			 	'Name' => 'name',
			 	'Created' => 'timestamp',
			 	'Published' => 'status'))
			 ->name('Content Page')
			 ->on('addedit')->action('ContentPageRevision');
			 
		$this->page->with('ContentPageRevision')
			 ->show(array(
			 	'Title' => 'page_title',
			 	'Created' => 'timestamp',
			 	'Published' => 'status'))
			 ->name('Content Page Revision')
			 ->link(array('parent', array('ContentPage', 'id')))
			 ->showCreate(false);
			 
		$this->page->with('ContentPage');
	}
	
	function getUserInterface() {
		include ('include/ContentPage.php');
		include ('include/ContentPageRevision.php');
		$pageid = ContentPage::keytoid($_REQUEST['page']);
		$pageid = $pageid['id'];
		$revid = ContentPage::activeRev($pageid);
		$revid = @$revid['id'];
		if(!is_null($revid)){
			$rev = ContentPageRevision::make($revid);
			$this->smarty->assign('content',$rev);
			$page = ContentPage::make($pageid);
			$this->parentSmarty->templateOverride = $page->getSmartyResource();
			$this->setPageTitle($rev->get('page_title'));
		} else {
			return $this->smarty->dispErr('404', &$this);
		}
		return $this->smarty->fetch('db:content.tpl');	 
	}
	
	function getAdminInterface() {
		$this->addJS('/modules/Content/js/admin/handleHome.js');
		
		return $this->page->render();
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
