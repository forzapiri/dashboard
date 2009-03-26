<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
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
