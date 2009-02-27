<?php
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
