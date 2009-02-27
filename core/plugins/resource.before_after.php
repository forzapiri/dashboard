<?php
function smarty_resource_before_after_source ($tpl_name, &$tpl_source, &$smarty_obj) {
	$args = unserialize($tpl_name);
	$file = $args[2];
	$params = array('resource_name' => $file);
	if (!$smarty_obj->_fetch_resource_info($params)) return false;
	$content = $params['source_content'];
	$match = explode($args[1], $content);
	if (2 != count($match)) return false;
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
	$tpl_timestamp = $params['resource_timestamp'];
	return true;
}

function smarty_resource_before_after_secure($tpl_name, &$smarty_obj) {return true;}

function smarty_resource_before_after_trusted($tpl_name, &$smarty_obj) {}
