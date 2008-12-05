<?php

/**
 * Smarty plugin to build the javascript for an AJAX call.
 * @file function.ajaxcall.php
 * @package Smarty
 * @subpackage plugins
 */

/* Render the output nessasary to generate an AJAX call.
 * 
 * @package Smarty
 * @subpackage plugins
 */
function smarty_function_ajaxcall($params, &$smarty) {
	require_once 'HTML/AJAX/Helper.php';
	
	$target = @$params ['target'];
	$call = @$params ['call'];
	$type = (! is_null ( @$params ['type'] ) ? @$params ['type'] : 'replace');
	
	$ajaxHelper = new HTML_AJAX_Helper ( );
	$ajaxHelper->serverUrl = '/AJAX/server.php';
	if (@isset ( $params ['stubs'] )) {
		$stubs = split ( ',', $params ['stubs'] );
		foreach ( $stubs as $stub ) {
			$ajaxHelper->stubs [] = $stub;
		}
	}

	if (@!$smarty->hasJSlibs) {
		echo $ajaxHelper->setupAJAX ();
	}
	$smarty->hasJSlibs = true;
	
	if (@is_null($params['loadJS'])) {
	//	echo $ajaxHelper->loadingMessage ( "Waiting on the Server ...", null, 'position: absolute; top: 0; left: 0; display: none;' );
		echo $ajaxHelper->updateElement ( $params ['target'], $params ['call'], $type, true );
		
		echo '<div id="' . $target . '">&nbsp;</div>';
	}
}

?> 