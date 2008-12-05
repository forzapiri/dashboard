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
function smarty_function_block($params,&$smarty) {
	if ($params['class']) {
		$module = Module::factory($params ['class']);
		$module->smarty->assign('module', $module);
		$smarty->assign('blockContent', $module->smarty->fetch($params['template']));
	} else {
		$smarty->assign('blockContent', $smarty->fetch($params['template']));
	}
	if ($params['blockid']) {
		$smarty->assign('blockID', $params['blockid']);
	} else {
		$smarty->clear_assign('blockID');
	}
	
	return $smarty->fetch('block.tpl');
}

?> 