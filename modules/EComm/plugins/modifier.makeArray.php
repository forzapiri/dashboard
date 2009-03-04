<?php
	function smarty_modifier_makeArray($string, $delimiter){
		if(is_array($string)){
			$string = implode('', $string);
		}
		$arr = explode($delimiter, $string);
		
	/*	foreach($arr as &$el){
			$el = str_replace("\n", '', $el);
			$el = str_replace("\r", '', $el);
		}*/
		
		return $arr;
	}
?>