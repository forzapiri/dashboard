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

if (! (SiteConfig::programmer() // If the site isn't live, usually show an error page.
	   || SiteConfig::get('live')
	   || (@$_REQUEST['module'] == 'User' && @$_REQUEST['section'] == 'logout'))) {
	$_REQUEST['module'] = "Content";
	$_REQUEST['page'] = "_ERROR_";
}

if (@!isset($_REQUEST['module'])) {
	$_REQUEST['module'] = SiteConfig::get('defaultModule');
}

require_once 'HTML/AJAX/Helper.php';
$ajaxHelper = new HTML_AJAX_Helper ( );

if ( $ajaxHelper->isAJAX () ){
	echo Module::factory($_REQUEST['module'], $smarty)->getUserInterface($_REQUEST);
} else {
	$smarty->addJS('/js/scriptaculous.js');

	$smarty->content[$_REQUEST['module']] = Module::factory($_REQUEST['module'], $smarty)->getUserInterface($_REQUEST);

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

	
	$smarty->assign ( 'module', $_REQUEST['module'] );
	if (isset($_SESSION['authenticated_user'])) {
		$smarty->assign_by_ref ( 'user', $_SESSION['authenticated_user'] );
	}
	$cachedModules = SiteConfig::get('cachedModules');
	if (!SiteConfig::programmer() && in_array ($_REQUEST['module'], (array) $cachedModules)) {
			$result = $smarty->render ('db:site.tpl', $smarty->templateOverride, false);
			$pageCache->save($result, CACHED_PAGE_INDEX);
			echo $result;
	} else {
		$smarty->render ( 'db:site.tpl', $smarty->templateOverride);
	}
}
