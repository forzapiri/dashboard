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

require_once 'MenuItem.php';

define( 'MENU_ROOT_PARENT_ID', 1);
define( 'MENU_UP', 'up' );
define( 'MENU_DOWN', 'down' );

class Menu {
	private $roots = array ( );
	protected $menu_id;
	private $menu = null;

	/* args to constructor */
	private $onlyactive;
	private $pubOnly;
	private $followContentMenus;
	
	public function __construct($menu_id = 1, $onlyactive = false, $pubOnly = true, $id = 0, $followContentMenus = false) {
		$this->onlyactive = $onlyactive;
		$this->pubOnly = SiteConfig::get('Content::restrictedPages') == 'true';
		$this->followContentMenus = $followContentMenus;

		$this->menu_id = $menu_id;
		if ($this->menu) $this->menu = MenuItem::make($id);
		$this->roots = $this->getChildren($menu_id);
	}
	
	private function childrenOf ($menu_id, $id) {
		// var_dump ("childrenOf ($menu_id, $id)");
		// var_dump ($_REQUEST);
		$where = $this->onlyactive ? $where = ' AND status="1" ' : '';
		$sql = "select * from menu where parentid=$id $where and menuid=$menu_id ORDER BY sort asc";
		//var_dump($sql);
		$result = Database::singleton()->query_fetch_all( $sql );
		return $result;
	}
	
	private $nodes;
	private function getChildren($menu_id) {
		/* Breadth First Search required so that circular references don't look silly
		 * (Circular references are only possible of we are traversing Content blocks.)
		 */
		$root = MenuItem::make();
		$root->setId(0);
		$root->setMenuid($menu_id);
		$root->setParentid(0);
		$root->parentItem = null;
		$root->depth = 0;
		$root->children = array();
		$queue = array($root);
		$this->nodes = array(0 => $root);
		while ($queue) {
			$v = array_shift ($queue);
			$id = $v->getId();
			$children = $this->childrenOf ($v->getMenuid(), $id);

			/* Obtain menus which are in the content page of current menu item
			 * This block of code presumes method getSubMenu() is implemented
			 * as in pk branch of content module.
			*/
			if ($id != 0 && $this->followContentMenus) {
				$item = MenuItem::make($id);
				if ($this->getModInfo($item->module_id) == 'Content' && $this->followContentMenus) {
					include_once(SITE_ROOT . '/modules/Content/include/ContentPage.php');
					$page = new CMSPage($item->getLinkId());
					$revs = $page->getActiveRevisions();
					$child = @$revs[0]->getSubMenu();
					if ($child) {
						$children = array_merge ($children, $this->childrenOf ($child['id'], 0));
					}
				}
			}

			foreach ($children as $child) {
				if ($child['module'] == 'Content' && ($this->pubOnly || $this->followContentMenus)) {
					include_once(SITE_ROOT . '/modules/Content/include/ContentPage.php');
					$data = ContentPage::make($child['link']);
					if ($this->pubOnly && ($data->get('allowed_group_id') != 0 && (!isset($_SESSION['authenticated_user']) || $data->get('allowed_group_id') != $_SESSION['authenticated_user']->get('group')))) continue;
				}
				$id = $child['id'];
				if (isset($this->nodes[$id])) {continue;}
				$child = MenuItem::make($id);
				$child->parentItem = $v;
				$child->setParentid($v === 0 ? 0 : $v->getId(0));
				$n = count ($v->children);
				if ($n>0) $v->children[$n-1]->bottom = false;
				$child->bottom = true;
				$child->depth = $v->depth+1;
				$child->top = !$n;
				$v->children[] = $child;
				$this->nodes[$id] = $child;
				$child->children = array();
				$queue[] = $child;
			}
		}
		return $this->nodes[0]->children;
	}
		
	public function getRoots() {
		return $this->roots;
	}
	
	public function getModInfo($id){
		$sql = 'select module from modules where id = "'.$id.'"';
		$result = Database::singleton()->query_fetch($sql);
		return $result['module'];
	}
	
	public function &findMenuItem($id,&$roots = null) {
		if (is_null( $roots ))
			$roots = $this->roots;
		foreach ( $roots as $root ) {
			if ($root->getId() == $id) {
				return $root;
			} else {
				if (! is_null( $root->children )) {
					$item = $this->findMenuItem( $id, $root->children );
				}
			}
		}
		return $item;
	}
	
	public function &toArray($roots = null,&$menu = array('0' => '[ Top Level Item ]'),$depth = 0) {
		if (is_null( $roots ))
			$roots = $this->roots;
		foreach ( $roots as $root ) {
			$menu [$root->getId()] = str_repeat( '--', $depth ) . $root->getDisplay();
			if (@$root->children) {
				$this->toArray( $root->children, $menu, $depth + 1 );
			}
		}
		return $menu;
	}
	
	public static function getLinkables($module) {
		$sql = 'select module from modules where id=' . $module;
		$moduleName = Database::singleton()->query_fetch( $sql );
		
		$module = Module::factory( $moduleName ['module'] );
		$result = $module->getValidLinks();
		$returnLinks = array ( );
		foreach ( $result as $link ) {
			$returnLinks [$link ['key']] = $link ['value'];
		}
		return $returnLinks;
	}
	private static $cookieQuery = null;
	private static $mainMenu = null;
	public static function mainMenu() {
		if (!self::$mainMenu) self::$mainMenu = new Menu(1, true);  // true = only active menus
		return self::$mainMenu;
	}
	public static function cookieCrumbsTo ($module, $link) {
		$menu = self::mainMenu();
		if (!self::$cookieQuery) {
			self::$cookieQuery = new Query("select id, menuid from menu where module=? and link=? order by id desc", "si");
		}
		$result = self::$cookieQuery->fetch($module, $link);
		if (!$result) return array();
		$id = $result['id'];
		$crumbs = array();
		if (isset($menu->nodes[$id]) && $menu->nodes[$id]) {
			$crumb = $menu->nodes[$id];
			while ($crumb->parentItem) {
				$crumbs[] = $crumb;
				$crumb = $crumb->parentItem;
			}
		}
		$crumbs = array_reverse($crumbs);
		return $crumbs;
	}
}
