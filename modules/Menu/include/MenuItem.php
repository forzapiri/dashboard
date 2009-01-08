<?php

/**
 * MenuItem
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * DETAILED CLASS TITLE
 * 
 * DETAILED DESCRIPTION OF THE CLASS
 * @package CMS
 * @subpackage Core
 */

class MenuItem extends DBRow {
	
	public $depth = null;
	public $top = null;
	public $bottom = null;
	public $linkables = null;
	
	 // DeprecatedRow has __get for calls to getBlah and setBlah.
	 // However, it causes other automatic functions to fail like serialize, wakeup, etc. 
	 
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'display', 'Display Name'),
			DBColumn::make('select', 'module', 'Module'),
			DBColumn::make('!select', 'link', 'Link to'),
			DBColumn::make('select', 'parentid', 'Parent Item'),
			DBColumn::make('select', 'target', 'Target Window', array('same'=>'Same Window', 'new'=>'New Window')),
			DBColumn::make('//status', 'status', 'Status'),
			DBColumn::make('//integer', 'sort'),
			DBColumn::make('?integer', 'menuid', 'Menu')
			);
		return new DBTable("menu", __CLASS__, $cols);
	}
	

	function getAddEditFormHook($form) {
		$el =& $form->getElement($this->quickformPrefix() . 'link');
		$obj = &Event_Dispatcher::getInstance('MenuItem')->post($this, 'linkables');
		$options = array();
		$form->getElement($this->quickformPrefix() . 'module')->_options = null;
		foreach(SiteConfig::get('linkables') as $linkable){
			$options[] = $linkable;
			$form->getElement($this->quickformPrefix() . 'module')->addOption($linkable, $linkable);
		}
		
		if ($this->getModule() == null) $this->setModule('Content');
		
		$module = Module::factory($this->getModule());
		$linkables = @call_user_func(array($module, 'getLinkables'));
		
		$el->_options = null;
		if(count($linkables) > 0){
			foreach ($linkables as $key => $itm) {
				$el->addOption($itm, $key);
			}
		}
		$menuid = $this->getMenuid();
		 // TODO:  WHY ISN'T THIS SET ALREADY ON A CREATE MENU?
		if (!$menuid) $menuid = $_REQUEST[$this->quickformPrefix() . 'menuid'];
		$menu = new Menu($menuid);
		$submenus = (@$_REQUEST['n'] <= SiteConfig::get('Menu::numberWithSubmenus'));
		$parent = $menu->toArray();
		$parent = $submenus? $parent : array ($parent[0]);
		$el =& $form->getElement($this->quickformPrefix() . 'parentid');
		$el->_options = null;
		foreach ($parent as $key => $itm) {
			$el->addOption($itm, $key);
		}
		
		$el =& $form->getElement($this->quickformPrefix() . 'module');
		$form->updateElementAttr($this->quickformPrefix() . 'module', array('onchange'=>'menuitems(this);'));
	}
	
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows("$where");}
	static function make($id = null) {return parent::make($id, __CLASS__);}
	function quickformPrefix() {return 'menuitem_';}

	public function getLinkTarget() {
		return Module::factory( $this->getModule() )->getLinkable( $this->get('link') );
		//return Module::factory( $this->getModule() )->linkHandler( $this->get('link') );
	}
	
	public function getLinkables() {
		$obj = &Event_Dispatcher::getInstance('MenuItem')->post($this, 'linkables');
		$a = array();
		if (!$this->linkables) return $a;
		foreach ($this->linkables as $key => $link) {
			$a[$key] = $key;
		}
		return $a;
	}
	
	public function move($direction) {
		$old = $this->getSort();
		if ($direction == 'up') {
			$this->setSort($this->getSort() - 1);
		} else if ($direction = 'down') {
			$this->setSort($this->getSort() + 1);
		}
		if ($this->getSort() < 0) $this->setSort(0);
		// var_dump ("Moving " . $this->getId() . " $direction $old => " . $this->getSort());
		$sql = 'select id from menu where menuid=' . e($this->getMenuid()) . ' and parentid=' . e($this->getParentid()) . ' and sort=' . e($this->getSort());
		$r = Database::singleton()->query_fetch($sql);
		$r = MenuItem::make($r['id']);
		$r->setSort($old);
		// var_dump ($this);
		// var_dump ($r);
		$r->save();
		$this->save();
		// Event_Dispatcher::getInstance('MenuItem')->post(&$this, 'onMove');
	}
}
DBRow::init('MenuItem');
?>
