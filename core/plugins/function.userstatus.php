<?php

function smarty_function_userstatus($params,&$smarty) {
	$user = $params['user'];
	if ($user instanceof User) {
		$user = new User_Profile($user->getId());
	}
	if ((strtotime($user->getLastTouched())) > (time() - (10 * 60))) {
		return '<em>Online</em>';
	}
	return 'Offline';
}

?> 