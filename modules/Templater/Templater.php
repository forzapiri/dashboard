<?php
/**
 * Skeleton Module
 * @author Christopher Troup <chris@norex.ca>
 * @package Modules
 * @version 2.0
 */

/**
 * Training module.
 * 
 * This is essentially an example to learn how to write modules for the new CMS
 * system. It contains the bare minumum code to qualify for inclusion. This is a
 * good place to copy structure from when creating a new custom module.
 * @package Modules
 * @subpackage Skeleton
 */
class Module_Templater extends Module {
	
	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getAdminInterface() {
		$this->addCSS('/modules/Templater/css/templates.css');
		$templates = Template::getAllTemplates();
		if (isset($_REQUEST['action'])){
			if($_REQUEST['action']=='otherinterface'){
				$page = new Page();
				$page->with('Template')
					 ->show(array(
							'Module' => 'module',
							'Path' => 'path',
							'Timestamp' => 'timestamp'
					 ))
					 ->pre('<h1>Micro Managing Templates</h1>. <a href="/admin/Templater" style="color:white;"><h3> click here to go back to main interface </h3></a>')
					 ->filter('order by timestamp desc');
				return $page->render();
			}
		}
		
		if (!isset($_REQUEST['template_id'])) {
			$this->smarty->assign('curtemplate', $templates[0]);
		} else {
			if (isset($_REQUEST['save'])) {
				$t = Template::make($_REQUEST['template_id']);
				$t->setData(u($_REQUEST['editor']));
				$t->setTimestamp(new NDate(date('Y-m-d H:i:s')));
				$t->setId(null);
				$t->save();
				$this->smarty->assign('curtemplate', $t);
				$templates = Template::getAllTemplates();
			} else if (isset($_REQUEST['switch_template'])) {
				$this->smarty->clear_assign('curtemplate');
				$this->smarty->assign('curtemplate', Template::make($_REQUEST['template']));
			} else if (isset($_REQUEST['switch_revision'])) {
				$this->smarty->clear_assign('curtemplate');
				$this->smarty->assign('curtemplate', Template::make($_REQUEST['revision']));
			} else {
				$this->smarty->assign('curtemplate', Template::make($_REQUEST['template_id']));
			}
		}
		
		$this->smarty->assign('templates', $templates);
		return $this->smarty->fetch( 'admin/templates.tpl' );
	}

}

?>