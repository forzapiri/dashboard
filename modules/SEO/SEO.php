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

class Module_SEO extends Module {
	
	public function __construct() {
		Router::connect('seo\/?$', array($this, 'show'));
		Router::connect('seo\/(?<name>\w+)', array($this, 'wewt'));
	}
	
	public function wewt($params) {
		return $params['name'];
	}
	
	public function show() {
		/* Make sure menu generation code is included */
		include_once(dirname(__FILE__) . '/../Menu/include/Menu.php');
		include_once(dirname(__FILE__) . '/../Menu/include/MenuItem.php');
		
		$menu = new Menu();
		
		if (@$params['encoding'] == 'gz') {
			ini_set("zlib.output_compression", "Off");
			$enc = in_array('x-gzip', explode(',', strtolower(str_replace(' ', '', $_SERVER['HTTP_ACCEPT_ENCODING'])))) ? "x-gzip" : "gzip";
			header("Content-Encoding: " . $enc);
		}
		
		header('Content-Type: application/xml');
		
		$this->smarty->assign('server', 'http://' . $_SERVER['SERVER_NAME']);
		$this->smarty->assign('menu', $menu->getRoots());
		$content =  $this->smarty->fetch( 'top.tpl' );
		if (@$params['encoding'] == 'gz') {
			echo gzencode($content, 9, FORCE_GZIP);
		} else {
			echo $content;
		}
		die();
	}

}
