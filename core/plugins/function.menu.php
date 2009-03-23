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
	return ($params['admin'])
		? adminMenu($params, $smarty)
		: frontendMenu($params, $smarty);
}

function adminMenu($params, &$smarty) {
	$activeModules = Config::getActiveModules();
	$initial = '<li class="borderRight' . (!isset($_REQUEST['module']) ? " active" : '') . '"><a href="/admin/" style="background-image: url(/images/admin/dashboard_active.png)">Dashboard</a></li>';
	$adminItems = array($initial);
	
	$i = 0;
	foreach ($activeModules as $module) {
		$i++;
		// Use object reflection to reverse engineer the class functions
		$modulename = 'Module_' . $module['module'];
		include_once SITE_ROOT . '/modules/' . $module['module'] . '/' . $module['module'] . '.php';
		$blah = new $modulename();
		$test = new ReflectionClass($blah);
		
		$moduleflag = false;
		if (SiteConfig::programmer()) {
			$moduleflag = true;
		}
		else if ($blah->page) {
			foreach ($blah->page->tables as $key => $table) {
				$perm = Permission::hasPerm($_SESSION['authenticated_user']->get('group'), $key, 'view');
				if (count($perm) > 0) {
					$moduleflag = true;
				}
			}
		}
		if (!$moduleflag) continue;
		
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
			unset($liClass);
			unset($active);
			if ($module['module'] == $_REQUEST['module']) {
				$active = ' active"';
			}
			
			if ($i != count($activeModules)) {
				$liClass = ' class="borderRight' . $active . '"';
			} else {
				$liClass = ' class="' . $active . '"';
			}
			$extra = SiteConfig::programmer() && !$module['enabled'] ? " text-decoration: line-through;" : "";
			$image = isset($blah->icon) ? $blah->icon : '/modules/Content/images/application_edit.png';
			$extra = " style='background-image: url($image); $extra'";
			if (isset($blah->page)) {
				$text = '';
				if (count($blah->page->heading) > 0) {
					$text .= '<div class="handle">&nbsp;</div>';
				}
				$text .= '<a href="/admin/' . $module['module'] . '"' . @$extra . '>' . $module['display_name'] . '</a>';
				if (count($blah->page->heading) > 0) {
					$text .= ' <ul' . (($module['module'] != $_REQUEST['module']) ? ' style="display: none;"' : '') . '>';
					foreach ($blah->page->heading as $key => $heading) {
						$text .= "\n  <li" . (($_REQUEST['section'] == $key) ? ' class="active"' : '') . '><a href="/admin/' . 
							$module['module'] . '&amp;section=' . $key . '">' . $heading .
							' (' . $blah->page->getCount($key) . ')' .  
							'</a></li>';
					}
					$text .= "\n </ul>";
				} else {
					$text .= ' <strong>(' . $blah->page->getCount() . ')</strong>';
				}
			} else {
				$text = '<a href="/admin/' . $module['module'] . '"' . @$extra . '>' . $module['display_name'] . '</a>';
			}
			
			$adminItems[] = "<li $liClass>$text</li>";
		}
	}
	if (SiteConfig::programmer(true)) {
		$adminItems[] = "<li>&nbsp;</li>";
		$options = "<option value=''>Switch View</option>\n";
		$options .= "<option value='Programmer'>Programmer</option>\n";
		foreach (Group::getAll() as $group) {
			$name=$group->getName();
			$options .= "  <option value='$name'>$name</option>\n";
		}
		$name = "programmerEmulating";
		$select = "<select id='$name' name='$name' onChange='document.programmerForm.submit()'>\n$options\n</select>\n";
		$form = "<form name='programmerForm' action='/admin' method='post'>\n$select\n</form>\n";
		$adminItems[] = $form;
	}
	
	$menuString = "<ul>\n" . implode("\n", $adminItems) . "\n</ul>\n";
	
	return $menuString;
}

function frontendMenu($params, &$smarty) {

}
