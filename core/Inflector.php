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

/*
 * Inspired by CakePHP's Inflector class
 */
 
class Inflector {
	public static function pluralize($string) {
		if(substr($string, 0, -1) == 's') { 
			return $string . 'es';
		} else if(substr($string, -2) == 'ry') { 
			return substr($string, 0, -1) . 'ies';
		} else {
			return $string . 's';
		}
		return false;
	}
	
	public static function camelize($string) {
		return preg_replace('/(^|_)(.)/e', "strtoupper('\\2')", $string);
	}
	
	public static function humanize($string) {
		return ucwords(str_replace("_", " ", $string));
	}
	
	public static function slug($string) {
		$map = array(
			'/à|á|å|â/' => 'a',
			'/è|é|ê|ẽ|ë/' => 'e',
			'/ì|í|î/' => 'i',
			'/ò|ó|ô|ø/' => 'o',
			'/ù|ú|ů|û/' => 'u',
			'/ç/' => 'c',
			'/ñ/' => 'n',
			'/ä|æ/' => 'ae',
			'/ö/' => 'oe',
			'/ü/' => 'ue',
			'/Ä/' => 'Ae',
			'/Ü/' => 'Ue',
			'/Ö/' => 'Oe',
			'/ß/' => 'ss',
			'/[^\w\s]/' => ' ',
			'/\\s+/' => '_',
			'/^[' . preg_quote('_', '/') . ']+|[' . preg_quote('_', '/') . ']+$/' => '',
		);
		return preg_replace(array_keys($map), array_values($map), $string);
	}
}
