<?php

/**
 * Smarty plugin to build the javascript for an AJAX call.
 * @file function.helpitem.php
 * @package Smarty
 * @subpackage plugins
 */

/* Render the output nessasary to generate an AJAX call.
 * 
 * @package Smarty
 * @subpackage plugins
 */
function smarty_function_helpitem($params, &$smarty) {
	return '<a href="javascript:getHelp(\'' . @$params['item'] . '\')" onmouseover="getHelp(\'' . @$params['item'] . '\')"><img src="/images/help.gif" /></a>';
}

?> 