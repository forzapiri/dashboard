<?php
/**
 * MenuTypes
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * DETAILED CLASS TITLE
 * 
 * 
 * DETAILED DESCRIPTION OF THE CLASS
 * @package CMS
 * @subpackage Core
 */

class MenuType extends DBRow {

	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'name', 'Display Name'),
			DBColumn::make('select', 'template', 'Template', array())
			);
			
		return new DBTable("menus", __CLASS__, $cols);
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
			if (SiteConfig::norex()) {
				foreach ($templates as $itm) {
					$path = $itm->getPath();
					$options[$path] = $path;
				}
			} else {
				foreach ($user_templates as $itm) {
					$options[$itm . '.tpl'] =  $itm;
				}
			}
			$el = ((count($user_templates) == 1 || $n <= SiteConfig::get('Menu::minimumNumber')) && !SiteConfig::norex())
			       ? $form->addElement('hidden', $user_templates[0] . '.tpl')
			       : $form->addElement('select', $id, 'Template', $options);
			$el->setValue($value);
			return true;
		default: false;
		}
	}
	
	static function make($id = null) {return parent::make($id, __CLASS__);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);} 
	
	public function getMenu() {
		return new Menu($this->getId());
	}
}

DBRow::init('MenuType');
?>