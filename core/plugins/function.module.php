<?php
/**
 * Smarty plugin to build the module content in the admin and frontend interfaces.
 * @file function.menu.php
 * @package Smarty
 * @subpackage plugins
 */


/* Render the content for a module (if it provides and interface for output.
 * Parameters are $params['admin']. If it is true then the interface returned
 * is for the admin interface. Otherwise, its returns the default user
 * interface.
 *
 * @package Smarty
 * @subpackage plugins
 */
function smarty_function_module($params,&$smarty) {
	if (@$params['namespace'] == 'block') {
		return Module::factory($params ['class'])->smarty->fetch($params['template']);
	}
	if (@$params ['admin']) {
		return adminInterface ( $params, $smarty );
	} else {
		return frontendInterface ( $params, $smarty );
	}
}

/* Check to see if the module provides an admin interface, and if so return it.
 */
function adminInterface($params,&$smarty) {
	if ($params['class'] == 'Dashboard') {
		$modules = array();
		foreach (Config::getActiveModules() as $module) {
			$modules[] = Module::factory($module['module']);
		}
		$smarty->assign('modules', $modules);
		return $smarty->fetch('dashboard.tpl');
	}
	$module = Module::factory ( $params ['class'], $smarty );
	if (isset($smarty->content[$params['class']]) && $module->user->hasPerm('CMS','view')) {
		return $smarty->content[$params['class']];
	} else {
		return $smarty->fetch('error.tpl');
	}
}

function frontendInterface($params,&$smarty) {
	if (isset($smarty->content[$params['class']])) {
		return $smarty->content[$params['class']];
	} else {
		return Module::factory ( $params ['class'] )->getUserInterface ($params);
	}

}
