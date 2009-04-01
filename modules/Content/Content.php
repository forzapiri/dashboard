<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

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
			
		if (SiteConfig::get('Content::restrictedPages') == 'true') {
			$this->page->tables['ContentPage']['Restricted to Group'] = array('allowed_group_id', array('Group', 'getName'));
		}
	}
	
	function getUserInterface() {
		if(ucfirst($_REQUEST['module']) == 'Content' && @empty($_REQUEST['page'])){
			$_REQUEST['page'] = SiteConfig::get('Content::defaultPage');
		}
		
		$isHome = ucfirst($_REQUEST['module']) == 'Content'
			&& (strtolower(ucfirst(@$_REQUEST['page']))
				== strtolower(SiteConfig::get('Content::defaultPage')));
		$this->parentSmarty->assign('ishome', $isHome);
		
		$pageid = @$_REQUEST['id'];
		if (@$_REQUEST['action'] == 'viewdraft') { // CHUNKS:  Admin preview of a page; allow preview only if visitor has addedit privilege
			if (!$this->user->hasPerm('ContentPage', 'addedit')) {
				return $this->smarty->dispErr('404', $this);
			}
			$status = $_REQUEST['status'];
			$page = ContentPage::make($pageid);
		} else {
			$status = 'active';  // CHUNK
			$pageid = ContentPage::keytoid($_REQUEST['page']);
			$pageid = $pageid['id'];
			$page = ContentPage::make($pageid);
			if (!$page->getStatus()) {
				return $this->smarty->dispErr('404', $this);
			}
			
			if (SiteConfig::get('Content::restrictedPages') == 'true' && ($page->get('allowed_group_id') != 0 && (!isset($_SESSION['authenticated_user']) || $page->get('allowed_group_id') != $_SESSION['authenticated_user']->get('group')))) {
				$auth_container = new CMSAuthContainer();
				$auth = new Auth($auth_container, null, 'authHTML');
				$auth->start();
				$auth->checkAuth();
				$s = new SmartySite();
				return $this->smarty->dispErr('401', $this, null, $s->fetch('login.tpl'));
			}
		}
		$this->smarty->assign('content',$page);
		$this->parentSmarty->templateOverride = $page->getSmartyResource();
		$this->setPageTitle($page->get('page_title'));
		$this->smarty->assign ('crumbs', Menu::cookieCrumbsTo("Content", $pageid));
		$this->smarty->assign ('submenu', Menu::submenuFor("Content", $pageid));
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
