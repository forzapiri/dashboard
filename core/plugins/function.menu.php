<?php

/**
 * Smarty plugin to build the menus in the admin and frontend interfaces.
 * @file function.menu.php
 * @package Smarty
 * @subpackage plugins
 */

/* Generate Menus. Choose which menu should be generated on the basis of the input parameters. Currently, two
 * types of menus are supported -- admin and frontend. $param['admin'] switches between generating admin interface (true) 
 * and the frontend interface (false)
 * 
 * @param admin True for admin menu, false for frontend interface menu
 * @param smarty Reference to the calling smarty class.
 */
function smarty_function_menu($params, &$smarty) {
	if ($params['admin']) {
		return adminMenu($params, $smarty);
	} else {
		return frontendMenu($params, $smarty);
	}
}

function adminMenu($params, &$smarty) {
	// Query for the items in reverse order to make it easier to build the menu string, since the last element
	// is not CSS classed. It is impossible to determine if the current element will be the last active module
	// providing an admin interface, so this is the best way to do it.
	//$activeModules = array_reverse(Config::getActiveModules());
	$activeModules = Config::getActiveModules();
	
	$adminItems = array('<li class="borderRight"><a href="/admin/">DASHBOARD</a></li>');
	
	$i = 0;
	foreach ($activeModules as $module) {
		$i++;
		// Use object reflection to reverse engineer the class functions
		$modulename = 'Module_' . $module['module'];
		include_once SITE_ROOT . '/modules/' . $module['module'] . '/' . $module['module'] . '.php';
		$blah = new $modulename();
		$test = new ReflectionClass($blah);
		
		// Determine if the current object provides and admin interface. Some modules may provide functionality
		// but not require a main admin interface, and instead accomplish their tasks with hooks or no interface
		// at all.
		if ($test->hasMethod('getAdminInterface')) {
			// If the array is empty push an un-classed array item onto the stack. If not, then push successive
			// array items with the required 'borderRight' class onto the stack.
			//if (count($adminItems) == 0) {
			//	$adminItems = array('<li><a href="/admin/?module=' . $module['module'] . '">' . strtolower($module['module']) . '</a></li>');
			//} else {
			//	array_unshift($adminItems, '<li><a href="/admin/?module=' . $module['module'] . '">' . strtolower($module['module']) . '</a></li>');
			//}
			if ($i != count($activeModules)) {
				$liClass = ' class="borderRight"';
			} else {
				unset($liClass);
			}
			$adminItems[] = '<li' . $liClass . '><a href="/admin/' . $module['module'] . '">' . strtoupper($module['display_name']) . '</a></li>';
		}
		
	}
	
	$menuString = '<ul>';
	$menuString .= implode(null, $adminItems);
	$menuString .= '</ul>';
	
	return $menuString;
}

function frontendMenu($params, &$smarty) {

}
?> 