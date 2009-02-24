<?php
/**
 * This file provides a framework for Modules
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * The module class provides a factory method to build Modules. 
 * 
 * You should never to to instantiate this class by itself. Instead you should access it
 * with something like:
 * <code>
 * $module = Module::factory('my_module');
 * </code>
 * @todo Provide handling for $_GET and $_POST variables and parse them into variable arrays.
 * @package CMS
 * @subpackage Core
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
		
		public function onPreDelete(Event_Notification &$notification) {
			fb('bubble pre-delete', 'Event Notification', FirePHP::INFO);
		}
		
		public function onPreSave(Event_Notification &$notification) {
			fb('bubble pre-save', 'Event Notification', FirePHP::INFO);
		}
		
		public function onPreToggle(Event_Notification &$notification) {
			fb('bubble pre-toggle', 'Event Notification', FirePHP::INFO);
		}
		
		public function onDelete(Event_Notification &$notification) {
			fb('bubble delete', 'Event Notification', FirePHP::INFO);
		}
		
		public function onSave(Event_Notification &$notification) {
			fb('bubble save', 'Event Notification', FirePHP::INFO);
		}
		
		public function onToggle(Event_Notification &$notification) {
			fb('bubble toggle', 'Event Notification', FirePHP::INFO);
		}
		
		public function __construct() {
			
		}
		
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
		public static final function &factory($name, &$parentSmarty = null) {
			if (@include_once SITE_ROOT . '/modules/' . $name . '/' . $name . '.php') {

				$classname = 'Module_' . $name;
				
				$module = new $classname;
				
				if (!is_null($parentSmarty)) {
					$module->parentSmarty =& $parentSmarty;
					$module->smarty =& $parentSmarty;
					if($parentSmarty->compile_id != 'admin'){
						try {
							$module->parentSmarty->templateOverride(SiteConfig::get($name."::templateOverride"));
						} catch (Exception $e){
						}
					}
				} else {
					$module->smarty = new SmartySite();
				}
				
				$module->dispatcher = &Event_Dispatcher::getInstance($name);
				
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
				
				$module->smarty->assign('module', &$module);
				
				// Give the module access to the site-wide DB connection. This LOOKS like each module
				// is assigned its own DB object, but the class singleton ensures that its actually
				// a shared connection.
				$module->db = Database::singleton();
				if (@isset($_SESSION['authenticated_user'])) {
					$module->user = User::make($_SESSION['authenticated_user']->getId());
					$module->smarty->assign_by_ref('user', $module->user);
					
				} 
				
				return $module;
			} else {
				$module = false;
				return $module;
			}
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

?>
