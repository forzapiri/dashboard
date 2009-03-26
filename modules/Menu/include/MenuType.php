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

class MenuType extends DBRow {

	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'name', 'Display Name'),
			DBColumn::make('select', 'template', 'Template', array())
			);
			
		return parent::createTable("menus", __CLASS__, $cols);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}
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

	public function getAddEditFormOld($target = null) {
		$el =& $form->getElement($this->quickformPrefix() . 'template');
		foreach (Template::getAllTemplates() as $itm) {
			$el->addOption($itm->getPath(), $itm->getPath());
		}
		return $form;
	}
	
	function addElementTo($form, $id, $value) {
		switch ($id) {
		case 'template':
			$n = (integer) @$_REQUEST['n'];
			$templates = Template::getAllTemplates();
			$options = array();
			$user_templates = SiteConfig::get('Menu::templates');
			if (SiteConfig::programmer()) {
				foreach ($templates as $itm) {
					$path = $itm->getPath();
					$options[$path] = $path;
				}
			} else {
				foreach ($user_templates as $itm) {
					$options[$itm . '.tpl'] =  $itm;
				}
			}
			$el = ((count($user_templates) == 1 || $n <= SiteConfig::get('Menu::minimumNumber')) && !SiteConfig::programmer())
			       ? $form->addElement('hidden', $user_templates[0] . '.tpl')
			       : $form->addElement('select', $id, 'Template', $options);
			$el->setValue($value);
			return true;
		default: false;
		}
	}
	
	public function getMenu() {
		return new Menu($this->getId());
	}
}

DBRow::init('MenuType');
