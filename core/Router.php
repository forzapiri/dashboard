<?php
class Router {
	private static $routes = array();
	
	public static function connect($regex, array $routes) {
		self::$routes[$regex] = $routes;
	}
	
	public static function match() {
		foreach (self::$routes as $key => $route) {
			if (preg_match('/' . $key . '/', $_SERVER['REQUEST_URI'])) {
				return $route;
			}
		}
		return false;
	}
}