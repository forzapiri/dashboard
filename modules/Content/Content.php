<?php
class Module_Content extends Module implements linkable {
	
	public $icon = '/modules/Content/images/page_edit.png';
	
	public function __construct() {
		parent::__construct();
		$this->page = new Page();
		$this->page->with('ContentPage')
			->show(array('Name' => 'name',
						 'Created' => 'timestamp',
						 'Published' => 'status',
						 'Draft' => array('id', array('ContentPage', 'getDraftForms'))))
			->on('addedit')->noAJAX()
			->filter('order by name')
			->name('Content Page');
	}
	
	function getUserInterface() {
		$pageid = @$_REQUEST['id'];
		if (@$_REQUEST['action'] == 'viewdraft') { // CHUNKS:  Admin preview of a page; allow preview only if visitor has addedit privilege
			if (!$this->user->hasPerm('ContentPage', 'addedit')) {
				return $this->smarty->dispErr('404', &$this);
			}
			$status = $_REQUEST['status'];
			$page = ContentPage::make($pageid);
		} else {
			$status = 'active';  // CHUNK
			$pageid = ContentPage::keytoid($_REQUEST['page']);
			$pageid = $pageid['id'];
			$page = ContentPage::make($pageid);
			if (!$page->getStatus()) {
				return $this->smarty->dispErr('404', &$this);
			}
		}
		$this->smarty->assign('content',$page);
		$this->parentSmarty->templateOverride = $page->getSmartyResource();
		$this->setPageTitle($page->get('page_title'));
		/* CHUNKS */
		$this->smarty->assign ('chunks', Chunk::getAllContentFor($page, $status));
		return $this->smarty->fetch('db:content.tpl');
	}
	
	function getAdminInterface() {
		ChunkManager::fieldAdminRequest(); // CHUNKS
		$this->addJS('/js/chunk.js'); // CHUNKS
		$this->addJS('/modules/Content/js/admin/handleHome.js');
		
		return $this->page->render();
	}
	
	public static function getLinkables($level = 0, $id = null){
		switch($level){
			case 1:
			default:
				$linkItems = ContentPage::getAll("where status = '1'", '');
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
