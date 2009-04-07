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
function smarty_resource_before_after_source ($tpl_name, &$tpl_source, &$smarty_obj) {
	$args = unserialize($tpl_name);
	$file = $args[2];
	$params = array('resource_name' => $file);
	if (!$smarty_obj->_fetch_resource_info($params)) return false;
	$content = $params['source_content'];
	$match = explode($args[1], $content);
	$count = count($match)-1;
	if (1 != $count) {
		trigger_error ("Resource $file has $count occurrences of string '$content'; should have exactly 1");
		return false;
	}
	switch ($args[0]) {
	case 'before': $tpl_source = $match[0]; break;
	case 'after': $tpl_source = $match[1]; break;
	default: return false;
	}
    return true;
  }

function smarty_resource_before_after_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj) {
	$args = unserialize($tpl_name);
	$file = $args[2];
	$params = array('resource_name' => $file);
	if (!$smarty_obj->_fetch_resource_info($params)) return false;
	$tpl_timestamp1 = $params['resource_timestamp'];
	
	$params = array('resource_name' => $smarty_obj->templateOverride);
	if (!$smarty_obj->_fetch_resource_info($params)) return false;
	$tpl_timestamp2 = $params['resource_timestamp'];
	
	$tpl_timestamp = ($tpl_timestamp1 > $tpl_timestamp2) ? $tpl_timestamp1 : $tpl_timestamp2;
	return true;
}

function smarty_resource_before_after_secure($tpl_name, &$smarty_obj) {return true;}

function smarty_resource_before_after_trusted($tpl_name, &$smarty_obj) {}
