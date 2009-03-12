<?php
function smarty_modifier_get_db_value($value, $tableName,$idField,$nameField)
{
	$sql = "select $nameField from $tableName where $idField = '" . e($value) . "'";
	$r = Database::singleton()->query_fetch($sql);
	return $r[$nameField];
}

/* vim: set expandtab: */

?>
