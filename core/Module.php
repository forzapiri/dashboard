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

abstract class Module {
	
		/**
		 * A module level database connection. 
		 * 
		 * This is pseudo-unnessasary since the Database is
		 * availible statically with Database::singleton(), but it saves a tiny bit of memory to
		 * have it instantiated now.
		 *
		 * @var Database
		 * @static 
		 */
		public $db;
		public $version;
		protected $template;
		public $name;
		private static $cache;
		
		public function __construct() {}
		
		/**
		 * Create and return reference to loaded module.
		 * 
		 * This determines if the nessasary files exist for the module to be created. If so, it creates
		 * a SmartySite class for the module to use, then assigns it template directories, compiled template
		 * directories and makes sure the plugins directory is set to the core.
		 *
		 * @param string $name
		 * @return ref|bool Reference to loaded module
		 */
		public static final function &factory($name) {
			if (isset(self::$cache[$name])) {
				return self::$cache[$name];
			}
			
			$ok = SiteConfig::programmer() || in_array ($name, SiteConfig::get('modules'));
			$ok = $ok && file_exists($inc = SITE_ROOT . "/modules/$name/$name.php"); // ? null : include_once $inc;
			if ($ok) {
				include_once $inc;
				$classname = 'Module_' . $name;
				
				$module = new $classname;
				$module->name = $name;
				
				$module->smarty = new SmartySite(); //$parentSmarty;
				
				/*if (!is_null($parentSmarty)) {
					$module->parentSmarty =& $parentSmarty;
					if($parentSmarty->compile_id != 'admin'){
						try {
							$module->parentSmarty->templateOverride(SiteConfig::get($name."::templateOverride"));
						} catch (Exception $e){
						}
					}
				} else {
					$module->smarty = new SmartySite();
				}*/
				global $smarty;
				$module->parentSmarty = &$smarty;
				
				// Set up module's Smarty resouce. Make sure it has its own template directory
				// as well as a unique compile id. Using the class name is a clever way of avoiding
				// computing a _real_ unique one, since the site architecture will throw and error
				// long before Smarty does if there are overlapping class names.
				// If the template directory 'local' exists then we will load from that directory
				// instead of the normal one. This allows us to seperate templated content on a 
				// site-by-site basis and further seperates core code from custom module code.
				//$module->smarty = new SmartySite();
				if (file_exists(SITE_ROOT . '/modules/' . $name . '/local')) {
					$module->smarty->template_dir = SITE_ROOT . '/modules/' . $name . '/templates/local';
				} else {
					$module->smarty->template_dir = SITE_ROOT . '/modules/' . $name . '/templates';
				}
				
				if (file_exists(SITE_ROOT . '/modules/' . $name . '/plugins')) {
					$module->smarty->plugins_dir[] = SITE_ROOT . '/modules/' . $name . '/plugins';
				}
				$module->smarty->compile_dir = SITE_ROOT . '/cache/templates';
				$module->smarty->plugins_dir[] = SITE_ROOT . '/core/plugins';
				$module->smarty->compile_id = $classname;
				
				$module->smarty->assign('module', $module);
				
				if (isset($_SESSION['authenticated_user'])) {
					$module->user = User::make($_SESSION['authenticated_user']->getId());
					$module->smarty->assign_by_ref('user', $module->user);
				} 
				self::$cache[$name] = $module;
				return $module;
			} else {
				$module = false;
				return $module;
			}
		}
		
		public function assign($var, $val) {
			$this->smarty->assign($var, $val);
		}
		
		public function fetch($template) {
			return $this->smarty->fetch($template);
		}
		
		public function addCSS($url, $mediaType = null) {
			$this->smarty->addCSS($url, $mediaType);
		}
		
		public function addJS($url) {
			$this->smarty->addJS($url);
		}
		
		public function setPageTitle($title) {
			$this->smarty->setPageTitle($title);
		}
		
		public function setMetaTitle($title) {
			$this->smarty->setMetaTitle($title);
		}

		public function setMetaDescription($desc) {
			$this->smarty->setMetaDescription($desc);
		}

		public function setMetaKeywords($kwrds) {
			$this->smarty->setMetaKeywords($kwrds);
		}
		
		public function templateOverride($template) {
			$this->parentSmarty->templateOverride = $template;
		}
}
