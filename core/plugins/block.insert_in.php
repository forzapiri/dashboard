<?php
function smarty_block_insert_in ($params, $content, &$smarty) {
	if (isset ($content)) {
		$file = $params['file'];
		$at = @$params['at'];
		$at = isset($params['at']) ? $params['at'] : '{module class=$module}';
		$args = serialize(array ('before', $at, $file));
		$before = $smarty->fetch ("before_after:$args");
		$args = serialize(array ('after', $at, $file));
		$after = $smarty->fetch ("before_after:$args");
		return "$before$content$after";
	}
}
