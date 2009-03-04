<?php
	function smarty_function_get_db_array($params, &$smarty){
		$sql = "select ".$params['value']." from ".$params['table']." where ".$params['where'];
		$r = Database::singleton()->query_fetch_all($sql);
		$smarty->assign($params['smarty_var'], $r);
	}
?>