<?php
function smarty_function_textarea($params,&$smarty){
	$id = $params['id'];
	$cols = $params['cols'];
	$rows = $params['rows'];
	$classes = split(',',$params['classes']);
	$html = '<textarea name="'.$id.'" id="'.$id.'" rows="'.$rows.'" cols="';
	foreach($classes as $class){
			$html .= "$class ";
	}
	$html .='"></textarea>';
	return $html;
}