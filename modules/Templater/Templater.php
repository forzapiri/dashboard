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

class Module_Templater extends Module {
	
	public $icon = '/modules/Templater/images/table_gear.png';
	
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
			if($_REQUEST['action']=='otherinterface' || 'add' || 'addedit' || 'delete'){
				$page = new Page();
				$page->with('Template')
					 ->show(array(
							'Module' => 'module',
							'Path' => 'path',
							'Timestamp' => 'timestamp'
					 ))
					 ->pre('<h2>Micro Managing Templates</h2><h5 style="color:red!important;"><a href="/admin/Templater"> click here to go back to main interface </a></h5>')
					 ->filter('order by timestamp desc')
					 ->paging(50);
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
