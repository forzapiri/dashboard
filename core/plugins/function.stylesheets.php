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
function smarty_function_stylesheets($params, &$smarty) {
	$str = '<link rel="stylesheet" href="/css/style.css,/css/cssMenus.css';
	if (count($smarty->css['norm']) > 0) {
		foreach ($smarty->css['norm'] as $css) {
			$str .= ',' . $css;
		}	
	}
	$str .= '" type="text/css" />' . "\n";
	
	if (count($smarty->css['print']) > 0) {
		$str .= '<link rel="stylesheet" href="';
		$count = 0;
		foreach ($smarty->css['print'] as $css) {
			$count++;
			if ($count != 1) $str .= ',';
			$str .= $css;
		}
		$str .= '" type="text/css" media="print" />' . "\n";
	}
	
	if (count($smarty->css['screen']) > 0) {
		$str .= '<link rel="stylesheet" href="';
		$count = 0;
		foreach ($smarty->css['screen'] as $css) {
			$count++;
			if ($count != 1) $str .= ',';
			$str .= $css;
		}
		$str .= '" type="text/css" media="screen" />' . "\n";
	}
	
	return $str;
}
