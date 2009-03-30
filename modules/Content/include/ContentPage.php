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

class ContentPage extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Page Name'),
			DBColumn::make('text', 'url_key', 'URL Key'),
			DBColumn::make('select', 'page_template', 'Page Template', Template::toArray('CMS')),
			DBColumn::make('text', 'page_title', 'Page Title'),
			'//timestamp',
			'//status'
			);
			
		if (SiteConfig::get('Content::restrictedPages') == 'true') {
			$cols[] = DBColumn::make('Group(name)', 'allowed_group_id', 'Restricted to Group'); 
		}
		return parent::createTable("content_pages", __CLASS__, $cols);
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

	function chunkable() {return 'Content';}
	function quickformPrefix() {return 'content_pages_';}
	
	function keytoid($name){
		$sql = 'select id from content_pages where url_key="'.$name.'"';
		$id = Database::singleton()->query_fetch($sql);
		return $id;
	}
	
	function activeRev($id) {
			$sql = 'select id from content_page_data where parent="'.$id.'" and status="1"';
			$revs = Database::singleton()->query_fetch($sql);
			return $revs;
	}
	
	public function getAddEditFormHook($form){
		// $form->registerRule('checkName', 'function', 'checkForHomeName', get_class($this));
		// $form->addRule($this->quickformPrefix().'name', "Cannot create another Home page", 'checkName', null, 'client');
		if ($this->getId()) {
			$form->removeElement($this->quickformPrefix().'page_template');
			$el = $form->addElement('hidden', $this->quickformPrefix() . 'page_template');
			$el->setValue($this->getPageTemplate());
			$el = $form->addElement('html', "<li><b>Site Template:</b> " . $this->getPageTemplate() . '</li>');
		}
		if($this->get('name') == SiteConfig::get('Content::defaultPage')){
			switch(@$_REQUEST['action']){
				//Disables home page from having name change
				case 'addedit':
					if($form->elementExists($this->quickformPrefix() . 'name')){
						$form->updateElementAttr($this->quickformPrefix() . 'name', 'readonly');
					}
					break;
				case 'toggle':
					
				default:
					break;
			}
		}
	}
	
	public function getAddEditFormBeforeSaveHook($form) {
		include_once(SITE_ROOT . '/core/plugins/modifier.urlify.php');
		$this->set('url_key', smarty_modifier_urlify($this->get('url_key')));
	}
	
	function checkForHomeName($elVal){return (!is_null($elVal) && ucfirst($elVal) != SiteConfig::get('Content::defaultPage'));}
	
	public static function checkForHome(&$n){
		fb('disable');
		if(@!$o = $n->getNotificationObject()){
			$o = $n;
		}
		
		if(ucfirst($o->get('name')) == SiteConfig::get('Content::defaultPage')){
			$n->cancelNotification();
		}
	}

	function getSmartyResource() {
		if ($t = $this->getPageTemplate()) {return "db:" . $t;}
		else return null;
	}
}
DBRow::init('ContentPage');
