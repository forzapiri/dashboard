<?php
class Router {
	private static $routes = array();
	
	public static function connect($regex, array $routes) {
		self::$routes[$regex] = $routes;
	}
	
	public static function match() {
		foreach (self::$routes as $key => $route) {
			if (preg_match('/' . $key . '/', $_SERVER['REQUEST_URI'], $matches)) {
				return array('identity' => $route, 'params' => $matches);
			}
		}
		if (!isset($_REQUEST['module'])) {
			$module = SiteConfig::get('defaultModule');
		} else {
			$module = $_REQUEST['module'];
		}
		
		return array('identity' => array(Module::factory($module), 'getUserInterface'), 'params' => $_REQUEST);
	}
	
	public static function module($_module) {
		return substr(get_class($_module[0]), 7);
	}
}