<?php
/**
 * SiteConfig
 * @author David Wolfe <wolfe@norex.ca>
 * @package CMS
 * @version 1.0
 */

/**
 * Stores configuration options for a client
 * 
 * SiteConfig options can be accessed by name (if unique) or by module/name pair.  Each option 
 * can optionally be configurable be the site administrator(s).  If an admin configurable option
 * is multi-valued (a list) then the list should be comma separated for consistency.  
 * @package CMS
 * @subpackage Core
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
 *    OR by viewing the admin page with NOREX on.
 *  To add a new type, see examples in include/SiteConfigType.php
 * 
 *  Note that "sort" only suggests the sort order within a module.  The primary sort
 *  is by Module name.
 */

class Module_SiteConfig extends Module {
	
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
			$option->setEditable(1 - $option->getEditable());
			$option->save();
			break;			
		case 'delete':
			$option->delete();
			$option = NULL;
			break;
		default:
		}
		$siteconfigs = SiteConfig::getAllSiteConfigs();
		$this->smarty->assign('siteconfigs', $siteconfigs);
		return $this->smarty->fetch( 'admin/siteconfigs.tpl' );
	}
}
?>