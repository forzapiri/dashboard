<?php
/**
 * Skeleton Module
 * @author Christopher Troup <chris@norex.ca>
 * @package Modules
 * @version 2.0
 */ 

/**
 * @package Modules
 * @subpackage Menu
 */
class Module_Menu extends Module {
	
	public $icon = '/modules/Menu/images/shape_align_left.png';
	
	public $version = '$Id$';
	public $linkables = array();
	
	public function __construct() {
		parent::__construct();
		$dispatcher = &Event_Dispatcher::getInstance('Menu');
		$dispatcher->addNestedDispatcher(Event_Dispatcher::getInstance());
		
		$menuitem_dispatcher = Event_Dispatcher::getInstance('MenuItem');
		$menuitem_dispatcher->addNestedDispatcher($dispatcher);
		
		$menuitem_dispatcher->addObserver(array('Menu', 'moveItem'), 'onMoveItem');
		
		$this->page = new Page();
		$this->page->with('MenuType')
			->show(array('Name' => 'name'))
			->name('Menu');
	}
	
	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getAdminInterface() {
		$this->addJS('/modules/Menu/js/menu.js');
		$this->addCSS('/modules/Menu/css/admin.css');
		
		switch (@$_REQUEST['section']) {
			case 'menuitem':
				$item = MenuItem::make(@$_REQUEST['menuitem_id']);
				switch (@$_REQUEST['action']) {
					case 'linkables':
						header('Content-type: application/javascript');
						$obj = &Event_Dispatcher::getInstance('MenuItem')->post(&$this, 'linkables');

						$module = Module::factory($_REQUEST['module']);
						$links = @call_user_func(array($module, 'getLinkables'));
						$result = array();
						
						foreach($links as $key => $link) {
							$result[] = array('key'=>$key,'value'=>$link);
						}
						return json_encode($result);
					case 'move':
						$item->move($_REQUEST['direction']);
						break;
					case 'toggle':
						$item->toggle();
						break;
					case 'delete':
						$item->delete();
						break;
					case 'addedit':
						if (isset($_REQUEST['menuitem_menu_id'])) {
							$item->setMenuid($_REQUEST['menuitem_menu_id']);
						}
						$form = $item->getAddEditForm('/admin/Menu');
						if (!$form->isProcessed()) {
							return $item->getAddEditForm('/admin/Menu')->display();
						}
						break;
				}
				break;
			case 'menutype':
				switch (@$_REQUEST['action']) {
					case 'addedit':
						$item = MenuType::make(@$_REQUEST['menutype_id']);
						$form = $item->getAddEditForm('/admin/Menu');
						if (!$form->isProcessed()) {
							return $item->getAddEditForm('/admin/Menu')->display();
						}
						break;
					case 'deleteMenu' : // This one deletes an entire menu, not just one item.
						$id = (integer) $_REQUEST['menutype_id'];
						$m = MenuType::make($id);
						$m->delete();
						$sql = "delete from content_rel where child_type='menu' and child_id=$id";
						Database::singleton()->query($sql);
						break;
				}
		}
		
		$menus = MenuType::getAll();
		$this->smarty->assign('minimumNumber', SiteConfig::get('Menu::minimumNumber'));
		$this->smarty->assign('maximumNumber', SiteConfig::get('Menu::maximumNumber'));
		$this->smarty->assign('numberWithSubmenus', SiteConfig::get('Menu::numberWithSubmenus'));
		$this->smarty->assign('templates', SiteConfig::get('Menu::templates'));
		$this->smarty->assign('menus', $menus);
		return $this->smarty->fetch( 'admin/menu.tpl' );
		
	}
	
	public function getUserInterface($params = null) {
		require_once 'include/Menu.php';
		require_once 'include/MenuType.php';
		
		if (isset($params['id'])) {
			$menu = new Menu($params['id'], true );
			$type = MenuType::make($params['id']);
		} else {
			$menu = new Menu(1, true );
			$type = MenuType::make(1);
		}

		$this->smarty->assign( 'menu', $menu->getRoots() );

		return $this->smarty->fetch( 'db:' . $type->getTemplate() );
	}
}

?>