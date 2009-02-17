<?php
/**
 * Skeleton Module
 * @author Christopher Troup <chris@norex.ca>
 * @package Modules
 * @version 2.0
 */

/**
 * Training module.
 * 
 * This is essentially an example to learn how to write modules for the new CMS
 * system. It contains the bare minumum code to qualify for inclusion. This is a
 * good place to copy structure from when creating a new custom module.
 * @package Modules
 * @subpackage Skeleton
 */
class Module_SEO extends Module {
	
	public function getUserInterface($params) {
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

?>