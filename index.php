<?php
/**
 * Site Initialization
 *
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @subpackage Core
 * @version 2.0
 */

//Insures that db-config exists. Runs installer if not
if(!file_exists('include/db-config.php') || !file_exists('templates_c')) header("Location: buildtools/install/install.php");

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

if (!SiteConfig::norex() && !SiteConfig::get('live')) {
	$_REQUEST['module'] = "Content";
	$_REQUEST['page'] = "_ERROR_";
}

if (@!isset($_REQUEST['module'])) {
	$_REQUEST['module'] = 'Content';
}

if(ucfirst($_REQUEST['module']) == 'Content' && @empty($_REQUEST['page'])){
	$_REQUEST['page'] = SiteConfig::get('Content::defaultPage');
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

	$smarty->assign ( 'module', $_REQUEST['module'] );
	if (isset($_SESSION['authenticated_user'])) {
		$smarty->assign_by_ref ( 'user', $_SESSION['authenticated_user'] );
	}
	$uncachedModules = SiteConfig::get('cacheNotTheseModules');
	if (!SiteConfig::norex()
		&& !is_null($uncachedModules) && is_array($uncachedModules)
		&& !in_array ($_REQUEST['module'], $uncachedModules)
		&& !in_array ('all', $uncachedModules)) {
			$result = $smarty->render ('db:site.tpl', $smarty->templateOverride, false);
			$pageCache->save($result, CACHED_PAGE_INDEX);
			echo $result;
	} else {
		$smarty->render ( 'db:site.tpl', $smarty->templateOverride);
	}
}
?>
