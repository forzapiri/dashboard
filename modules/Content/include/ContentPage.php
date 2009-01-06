<?php
/**
 * Blocks
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

class ContentPage extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Page Name'),
			DBColumn::make('text', 'url_key', 'URL Key'),
			'//timestamp',
			'//status'
			);
		return new DBTable("content_pages", __CLASS__, $cols);
	}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	function quickformPrefix() {return 'content_pages_';}
	
	function keytoid($name){
		$sql = 'select id from content_pages where url_key="'.$name.'"';
		$id = Database::singleton()->query_fetch($sql);
		return $id;
	}
	
	function activeRev($id){
			$sql = 'select id from content_page_data where parent="'.$id.'" and status="1"';
			$revs = Database::singleton()->query_fetch($sql);
			return $revs;
	}
	
	public function getAddEditFormHook($form){
		$form->registerRule('checkName', 'function', 'checkForHomeName', get_class($this));
		$form->addRule($this->quickformPrefix().'name', "Cannot create another Home page", 'checkName', null, 'client');
		if($this->get('name') == 'Home'){
			switch($_REQUEST['action']){
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
	
	function checkForHomeName($elVal){return (!is_null($elVal) && ucfirst($elVal) != 'Home');}
	
	public static function checkForHome(&$n){
		fb('disable');
		if(@!$o = $n->getNotificationObject()){
			$o = $n;
		}
		
		if(ucfirst($o->get('name')) == 'Home'){
			$n->cancelNotification();
		}
	}
	
}
DBRow::init('ContentPage');
?>