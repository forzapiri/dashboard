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

function smarty_resource_db_source ($tpl_name, &$tpl_source, &$smarty_obj)
{
	$sql = 'select * from templates where path="' . $tpl_name . '" and module="' . $smarty_obj->compile_id . '" order by `timestamp` desc limit 1';
    $r = Database::singleton()->query_fetch($sql);
    $tpl_source = $r['data'];
	// $r = Template::getRevision($smarty_obj->compile_id, $tpl_name);
	// $tpl_source = $r->getData();
    return true;
}

function smarty_resource_db_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj)
{
	$sql = 'select * from templates where path="' . $tpl_name . '" and module="' . $smarty_obj->compile_id . '" order by `timestamp` desc limit 1';
    $r = Database::singleton()->query_fetch($sql);
    $tpl_timestamp = strtotime($r['timestamp']);
    
	// $r = Template::getRevision($smarty_obj->compile_id, $tpl_name);
	// $tpl_timestamp = $r->getTimestamp()->get(DATE_FORMAT_UNIXTIME);
    return true;
}

function smarty_resource_db_secure($tpl_name, &$smarty_obj)
{
    // assume all templates are secure
    return true;
}

function smarty_resource_db_trusted($tpl_name, &$smarty_obj)
{
    // not used for templates
}
