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

function smarty_modifier_urlify($str) {
	$str = htmlentities($str);
	$str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
	$str = preg_replace("/[^A-Z0-9]/i", ' ', $str);
	$str = preg_replace("/\s+/i", ' ', $str);	
	$str = trim($str);
	
	$str = str_replace(' ', '-', $str);
	
	return strtolower($str);
}
