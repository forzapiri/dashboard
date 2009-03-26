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

/*
 * Usage notes:
 * 
 *  SiteConfig::get('option')             // For global (module is null)
 *  SiteConfig::get('DMS::option')        // Module DMS
 * 
 *  SiteConfig::set('option', $value)     // Set configuration option
 *  SiteConfig::set('DMS::option', $value)
 *  
 *  New options are added by explicitly editing the db table config_options 
 *    OR by viewing the admin page as a Programmer
 *  To add a new type, see examples in include/SiteConfigType.php
 * 
 *  Note that "sort" only suggests the sort order within a module.  The primary sort
 *  is by Module name.
 */

class Module_SiteConfig extends Module {
	public function __construct() {
		parent::__construct();
		$this->page = new Page();
		$this->page->with('SiteConfig')
			->show(array('Description' => 'description',
						 'Value(s)' => 'value'))
			->name('Site Configuration');
		
	}
	

	public $icon = '/modules/SiteConfig/images/cog.png';
	
	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getAdminInterface() {
        $id = @$_REQUEST['siteconfig_id'];
        $option = SiteConfig::make($id);
		switch (@$_REQUEST['action']) {
		case 'addedit':
			$form = $option->getAddEditForm();
			if ($form->validate() && $form->isSubmitted() && (isset($_REQUEST['siteconfig_submit']))) {
				// do nothing
			} else { 
				return $form->display();
			}
			break;
		case 'toggle':
			if (!SiteConfig::programmer()) break;
			$option->setEditable(1 - $option->getEditable());
			$option->save();
			break;			
		case 'delete':
			if (!SiteConfig::programmer()) break;
			$option->delete();
			$option = NULL;
			break;
		default:
		}
		$siteconfigs = SiteConfig::getAll();
		$this->smarty->assign('siteconfigs', $siteconfigs);
		return $this->smarty->fetch( 'admin/siteconfigs.tpl' );
	}
}
