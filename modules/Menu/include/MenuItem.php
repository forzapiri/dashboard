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
		return parent::createTable("menu", __CLASS__, $cols);
	}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function countAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}

	function quickformPrefix() {return 'menuitem_';}
	

	function getAddEditFormHook($form) {
		$el =& $form->getElement($this->quickformPrefix() . 'link');
		$options = array();
		$form->getElement($this->quickformPrefix() . 'module')->_options = null;
		foreach(SiteConfig::get('linkables') as $linkable){
			$options[] = $linkable;
			$form->getElement($this->quickformPrefix() . 'module')->addOption($linkable, $linkable);
		}
		$form->getElement($this->quickformPrefix() . 'module')->addOption('Web Link', 'Web Link');
		
		if ($this->getModule() == null) $this->setModule('Content');
		
		if ($this->get('module') != 'Web Link') {
		
			$module = Module::factory($this->getModule());
			$linkables = @call_user_func(array($module, 'getLinkables'));
			
			$el->_options = null;
			if(count($linkables) > 0){
				foreach ($linkables as $key => $itm) {
					$el->addOption($itm, $key);
				}
			}
		} else {
			$form->removeElement($this->quickformPrefix() . 'link');
			$newlink = $form->createElement('text', $this->quickformPrefix() . 'link', 'Link To');
			$newlink->setValue($this->get('link'));
			$form->insertElementBefore($newlink, $this->quickformPrefix() . 'parentid');
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
	

	function &save() {
		if (!$this->getId()) {
			$this->setSort($this->getId());
		}
		return parent::save();
	}
	
	public function getLinkTarget() {
		if ($this->get('module') == 'Web Link') return $this->get('link');
		return Module::factory( $this->getModule() )->getLinkable( $this->get('link') );
	}
	
	public function getLinkables() {
		$a = array();
		if (!$this->linkables) return $a;
		foreach ($this->linkables as $key => $link) {
			$a[$key] = $key;
		}
		return $a;
	}

	public function swapSort($item1, $item2) {
		$s1 = $item1->getSort();
		$s2 = $item2->getSort();
		$item1->setSort($s2);
		$item2->setSort($s1);
	}
	
	public function move($direction) {
		$old = $this->getSort();
		$id = (integer) $this->getMenuid();
		$p = (integer) $this->getParentid();
		$s = (integer) $this->getSort();
		if ($direction == 'up') {
			$sql = "select * from menu where menuid=$id and parentid=$p and sort<$s order by sort desc limit 1";
		} else if ($direction = 'down') {
			$sql = "select * from menu where menuid=$id and parentid=$p and sort>$s order by sort limit 1";
		}
		$other = MenuItem::make(Database::singleton()->query_fetch($sql));
		$this->swapSort ($this, $other);
		$other->save();
		$this->save();
	}
}
DBRow::init('MenuItem');
