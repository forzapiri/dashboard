<?php
function smarty_function_taghook($params, &$smarty) {
	$params['data'] = str_replace('{'.$params['hook'].'}', $smarty->fetch($params['repTpl']), $params['data']);
	echo $params['data'];
}
?>