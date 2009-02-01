<?php

function smarty_modifier_urlify($str) {
	$str = htmlentities($str);
	$str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
	$str = preg_replace("/[^A-Z0-9]/i", ' ', $str);
	$str = preg_replace("/\s+/i", ' ', $str);	
	$str = trim($str);
	
	$str = str_replace(' ', '-', $str);
	
	return strtolower($str);
}
?> 