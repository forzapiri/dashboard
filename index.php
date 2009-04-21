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

//Insures that db-config exists. Runs installer if not
if(!file_exists('include/db-config.php') || !file_exists('cache/templates')) header("Location: buildtools/install/install.php");

/*
 * Kicks things off with initiliziation of the general framework infrastructure.
 */
include_once 'include/Site.php';
// NOTE that Site.php now checks for cached copy and die() is called if found

/*
 * Assess whether we are logging in on this page request.
 */
if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
	$auth_container = new CMSAuthContainer();
	$auth = new Auth($auth_container, null, 'authInlineHTML');
	$auth->start();
}

SiteConfig::warnInstall();

$_module_to_load = Router::match();

require_once 'HTML/AJAX/Helper.php';
$ajaxHelper = new HTML_AJAX_Helper ( );

if ( $ajaxHelper->isAJAX () ){
	echo $_module_to_load['identity'][0]->getUserInterface($_REQUEST);
} else {
	$smarty->addJS('/js/prototype.js');
	$smarty->addJS('/js/scriptaculous.js');
	
	$_module_name = Router::module($_module_to_load['identity']);
	$smarty->addJS('/js/frontend.js');
	$smarty->addJS('/js/sifr.js');
	$smarty->addJS('/js/sifr-config.js');
	$smarty->addJS('/js/prototip.js');
	$smarty->addCSS('/css/style.css');
	$smarty->addCSS('/css/cssMenus.css');
	$smarty->addCSS('/css/prototip.css');
	$smarty->addCSS('/css/sIFR-screen.css', 'screen');
	$smarty->addCSS('/css/sIFR-print.css', 'print');

	$smarty->content[$_module_name] = call_user_func($_module_to_load['identity'], $_module_to_load['params']);
	$smarty->assign ( 'module', $_module_name );

	$smarty->template_dir = SITE_ROOT . '/templates/';
	$smarty->compile_dir = SITE_ROOT . '/cache/templates';
	$smarty->plugins_dir[] = SITE_ROOT . '/core/plugins';
	$smarty->compile_id = 'CMS';

	//load the request uri into an array for smarty to access globally.
	$inurl = strtolower($_SERVER['REQUEST_URI']);
	$inurl = split('/',$inurl);
	$inurl = array_reverse($inurl);
	$inurl = array_flip($inurl);
	$smarty->assign('path',$inurl);

	
	if (isset($_SESSION['authenticated_user'])) {
		$smarty->assign_by_ref ( 'user', $_SESSION['authenticated_user'] );
	}
	$cachedModules = SiteConfig::get('cachedModules');
	if (!SiteConfig::programmer() && in_array ($_module_name, (array) $cachedModules)) {
			$result = $smarty->render ('db:site.tpl', $smarty->templateOverride, false);
			$pageCache->save($result, CACHED_PAGE_INDEX);
			echo $result;
	} else {
		$smarty->render ( 'db:site.tpl', $smarty->templateOverride);
	}
}
