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
function smarty_function_monthevents($params,&$smarty) {
	$today = getdate();
	$year = $today['year'];
	$month = $today['mon'];
	
	$events = Calendar::getAllCalendarEvents(SiteConfig::get('Calendar::frontPage'), $year, $month);
	
	$smarty->assign('events', $events);
	
	require_once('function.calendar.php');
	$r = smarty_function_calendar(array('url_format'=>'/calendar/%Y/%m/%d', 'month'=>$month, 'year'=>$year), $smarty);
}

?> 