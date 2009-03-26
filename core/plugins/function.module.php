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


/* Render the content for a module (if it provides and interface for output.
 * Parameters are $params['admin']. If it is true then the interface returned
 * is for the admin interface. Otherwise, its returns the default user
 * interface.
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
