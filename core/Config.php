<?php

/**
 * The config class provides a get/set mechanism for both global CMS options
 * as well as module specific options.
 * @package CMS
 * @author Christopher Troup <chris@norex.ca>
 * @version 2.0
 */

/**
 * Get and Set module and core options.
 * 
 * Your should never try to instatiate this class by itself. It WOULD be resource
 * intensive that way. Instead, use its singleton() accessor method to get its 
 * static reference.
 * @package CMS
 * @subpackage Core
 */
class Config {

	/**
	 * Contains a reference to the single instance of the config object
	 *
	 * @var Config
	 * @static 
	 */
	private static $instance;

	/**
	 * Contains an array of global CMS options
	 *
	 * @var array
	 */
	public $options;

	/**
	 * An array of currently active modules
	 *
	 * @var array
	 * @static
	 */
	private static $activeModules = null;


	/**
	 * Return a reference to the Config object
	 * 
	 * If the object has not yet been created, then create the object and
	 * set a link to it. Otherwise, skip creating the object and simply
	 * return the link.
	 *
	 * @return ref
	 * @static 
	 */
	public static function singleton() {
		if (! isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c();
		}
		
		return self::$instance;
	}

	
	private static $modules_flipped;
	private static function compare($a,$b) {
		return self::$modules_flipped[$a['module']]
			 - self::$modules_flipped[$b['module']];
	}
	/**
	 * Get currently active modules
	 *
	 * @return array
	 * @static 
	 */
	public static function getActiveModules() {
		// A module Foo is reported as active if
		// (1)  It is listed in the modules table
		// (2)  The file modules/Foo/Foo.php is readable, and
		// (3)  You are norex() OR the module is listed in SiteConfig::modules
		$norex = SiteConfig::norex();
		if ($norex || is_null(self::$activeModules)) { // WHEN YOU FIRST LOG IN AS NOREX, CAN'T USE CACHED COPY
			if ($norex) {
				$modules = scandir(SITE_ROOT . '/modules/');
			} else {
				$modules = SiteConfig::get('modules');
			}
			self::$modules_flipped = array_flip($modules);
			$sql = '';
			foreach ($modules as $module) {
				$sql .= " or module='$module'";
			}
			$sql = substr ($sql, 3); // REMOVE INITIAL "or"
			$sql = "select * from modules where $sql";
			$modules = Database::singleton()->query_fetch_all($sql);
			
			$active = array();
			foreach ($modules as $mod) {
				$name = $mod['module'];
				if (is_readable (SITE_ROOT . '/modules/' . "$name/$name.php"))				
					$active[$mod['id']] = $mod;
			}
			usort($active, array('Config', 'compare'));
			if ($norex) {
				foreach ($active as &$module) {
					$module['display_name'] = $module['module'];
				}
			}
			self::$activeModules = $active;
		}
			
		return self::$activeModules;
	}

	/**
	 * Checks to see if the passed module is active
	 *
	 * @param string $name
	 * @return bool True if module is active, false otherwise
	 */
	public function getIsModuleActive($name) {
		
		foreach (self::getActiveModules() as $module) {
			if ($module['module'] == $name)
				return true;
		}
		return false;
	}
}
