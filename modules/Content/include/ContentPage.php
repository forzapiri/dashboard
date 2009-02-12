<?php
class ContentPage extends DBRow {
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Page Name'),
			DBColumn::make('text', 'url_key', 'URL Key'),
			DBColumn::make('select', 'page_template', 'Page Template', Template::toArray('CMS')),
			'//timestamp',
			'//status'
			);
		return new DBTable("content_pages", __CLASS__, $cols);
	}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	static function make($id = null) {return parent::make($id, __CLASS__);}
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
		$form->registerRule('checkName', 'function', 'checkForHomeName', get_class($this));
		$form->addRule($this->quickformPrefix().'name', "Cannot create another Home page", 'checkName', null, 'client');
		if ($this->getId()) {
			$form->removeElement($this->quickformPrefix().'page_template');
			$el = $form->addElement('hidden', $this->quickformPrefix() . 'page_template');
			$el->setValue($this->getPageTemplate());
			$el = $form->addElement('html', "<b>Site Template:</b> " . $this->getPageTemplate());
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
	
	public function getAddEditFormSaveHook($form) {
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

	function getRequirements($smarty) {
		$name = $this->getPageTemplate();
		if (!$name) return false;
		$template = Template::getRevision('CMS', $name);
		if (!$template) return false;
		$requirements = preg_match_all('/{\* ?[A-Z]+ ?\((.*)\): (.*) \*}/', $template->getData(), $matches, PREG_SET_ORDER);
		if (!$requirements) return false;
		foreach ($matches as $req) {
			$x = &$results[];
			$x['label'] = $req[1];
			$x['types'] = array_map ('trim', split (',', $req[2]));
		}
		return $results;
	}
}
DBRow::init('ContentPage');
?>
