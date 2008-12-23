<?php

/**
 * Site Initialization
 *
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @subpackage Core
 * @version 2.0
 */
error_reporting(E_ALL);

date_default_timezone_set("America/Halifax");

function var_log($var, $prefix="") {
	if ($prefix) $prefix .= ': ';
   	if ($var === null) $var = 'NULL';
   	elseif ($var === true) $var = 'true';
   	elseif ($var === false) $var = 'false';
	error_log ($prefix . print_r($var, true));
	return $var;
}

define('DEBUG', isset($_REQUEST['DEBUG']));
define('NOREX', isset($_REQUEST['NOREX']));

$startTime = microtime(true);

define('SITE_ROOT', realpath(dirname(__FILE__) . '/../'));
set_include_path(get_include_path() . PATH_SEPARATOR . SITE_ROOT . '/core' . PATH_SEPARATOR . SITE_ROOT . '/core/PEAR' . PATH_SEPARATOR . '/usr/share/php/');

function error_handler($errno, $errstr, $errfile, $errline) {
	require_once('Ticket.php');
	$t = new Ticket();
	$t->errno = $errno;
	$t->errstr = $errstr;
	$t->errfile = $errfile;
	$t->errline = $errline;
		
	$t->submit();
}
// set to the user defined error handler
$old_error_handler = set_error_handler('error_handler', E_ERROR | E_PARSE);

include_once(SITE_ROOT . '/core/libs/Smarty.class.php');
include_once(SITE_ROOT . '/core/libs/Smarty_Compiler.class.php');
include_once(SITE_ROOT . '/include/fb.php');

session_start();

//date_default_timezone_set('America/Halifax');
define('DISPLAY_TYPE_TABLE', 'table');

function getSerializedRequest() {
	// Returns first serialized variable from $_REQUEST
	parse_str ($_REQUEST['data'], $var);
	foreach ($var as $result) {
		return $result;
	}
}

// To avoid having 'require' and 'include' all over the place, try
// and autoload the class from the core directory.
function __autoload($class_name) {
	if (@include_once SITE_ROOT . '/core/' . $class_name . '.php') return;
	if (@include_once SITE_ROOT . '/modules/' . $_REQUEST['module'] . '/include/' . $class_name . '.php') return;
	foreach (Config::getActiveModules() as $module) {
		if (@include_once SITE_ROOT . '/modules/' . $module['module'] . '/include/' . $class_name . '.php') return;
	}
}

function e($itm) {
	return Database::singleton()->escape($itm);
}

function u($itm) {
	return Database::singleton()->unescape($itm);
}

function array_flatten($array, $preserve_keys = 1, &$newArray = Array()) {
	foreach ($array as $key => $child) {
		if (is_array($child)) {
			$newArray =& array_flatten($child, $preserve_keys, $newArray);
		} elseif ($preserve_keys + is_string($key) > 1) {
			$newArray[$key] = $child;
		} else {
			$newArray[] = $child;
		}
	}
	return $newArray;
}

function authHTML() {
	global $smarty;
	 $smarty->template_dir = SITE_ROOT . '/templates';
	 $smarty->compile_dir = SITE_ROOT . '/templates_c';
	 $smarty->plugins_dir[] = SITE_ROOT . '/core/plugins';
	 
	$config = Config::singleton();
	$modules = $config->getActiveModules();

	if(isset($modules[0]['module'])){
		$smarty->assign('activemodule', $modules[0]['module']);
	}
	$smarty->assign('module', 'User');

	$content = $smarty->fetch('login.tpl');
	$smarty->content['User'] = $content;

	$smarty->render('db:site.tpl');
}

function authInlineHTML() {

	global $smarty;

	$content = $smarty->fetch('login.tpl');	

	$smarty->content[] = $content;
	//$content = $smarty->fetch('login.tpl');

	return $content;	
}


//$lang = 'en_CA';
//$_SESSION['lang'] = $lang;

//putenv("LANGUAGE=" . $_SESSION['lang']); //This works
//putenv("LANG=" . $_SESSION['lang']); // This DOES NOT WORK

//setlocale(LC_MESSAGES,$_SESSION['lang']);

//$domain = "messages"; //What you named your .po files
//bindtextdomain($domain,"/home/mini/workspace/Norex2/I18N/locale"); //Where you put the locale dir.
//textdomain($domain);

class SmartySite extends Smarty {

	public $css = array();
	public $js = array();
	public $title, $metaTitle, $metaDescription, $metaKeywords;
	public $templateOverride;
	
	/* In order to use function chaining (object dereferencing) we need to redefine the compiler class */
	public $compiler_class = 'Smarty_Compiler_Norex'; 

	function __construct() {
		$this->Smarty();
		/**
		 * This is a HACK. It sucks and I hate doing it. Sets the default namespace to module.
		 * @todo I really want to get rid of this namespace hack... somehow
		 */
		$this->assign('type', 'module');
		$this->compile_id = 'CMS';
	}
	
	function trigger_error($error_msg, $error_type = E_USER_WARNING)
    {
    	echo $this->dispErr(500, Module::factory('Content'), null, $error_msg);
    }

	function render($template, $override = null) {
		if(!$override==null){
               $this->templateOverride($override);
        }
		
		$this->assign_by_ref('css', $this->css);
		$this->assign_by_ref('js', $this->js);
		$this->assign_by_ref('title', $this->title);
		$this->assign_by_ref('metaTitle', $this->metaTitle);
		$this->assign_by_ref('metaDescription', $this->metaDescription);
		$this->assign_by_ref('metaKeywords', $this->metaKeywords);

		if (is_null($this->title)) {
			$this->title = SiteConfig::get('Content::defaultPageTitle');
		}
		$this->assign_by_ref('title', $this->title);

		global $memory;
		global $startTime;
		
		if (!empty($this->templateOverride)) {
                $this->display($this->templateOverride);
        } else $this->display($template);

		if (function_exists('memory_get_peak_usage') && function_exists('memory_get_usage')) {
			$memory .= 'Peak: ' . number_format(memory_get_peak_usage() / 1024, 0, '.', ',') . " KB \n";
			$memory .= 'End: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . " KB \n";
			$memory = 'Page generated in ' . (microtime(true) - $startTime) . ' seconds | Memory Usage: ' . ($memory);
			if (DEBUG) Debug::singleton()->addMessage('Load Time', $memory);
		}

		echo trim(@$output);
		
	}

	function addCSS($url, $mediaType = null) {
		if(is_null($mediaType)) $mediaType = 'norm';
		if (!array_key_exists($mediaType, $this->css) || !in_array($url, $this->css[$mediaType])) {
			$this->css[$mediaType][] = $url;
		}
	}

	function addJS($url) {
		if (!in_array($url, $this->js)) {
			$this->js[] = $url;
		}
	}

	function setPageTitle($title) {
		$this->title = $title;
	}
	
	function templateOverride($templateFile) {
                if (!empty($templateFile)) $this->templateOverride = $templateFile;
    }
	
	
	function setMetaTitle($metaTitle) {
		$this->metaTitle = $metaTitle;
	}
	
	function setMetaDescription($metaDescription) {
		$this->metaDescription = $metaDescription;
	}
	
	function setMetaKeywords($metaKeywords) {
		$this->metaKeywords = $metaKeywords;
	}
	
	function dispErr($err, &$obj, $page = null, $error_message = null){
		switch($err){
			case '404':
				header("HTTP/1.1 404 Not Found"); 
				break;
			case '500':
				header('HTTP/1.1 500 Internal Server Error');
				break;
			default:
				break;
		}
		
		$template = '';
		$oldTempDir = $obj->smarty->template_dir;
		
		if ($error_message) $obj->smarty->assign('error_message', $error_message);
		
		switch($page){
			case '_ERROR_':
				if(file_exists(SITE_ROOT . '/templates/errors/' . $err . '.tpl')){
					$obj->smarty->template_dir = SITE_ROOT . '/templates/';
					$template = $obj->smarty->fetch('errors/' . $err . '.tpl');
				} else {
					$obj->smarty->template_dir = SITE_ROOT . '/templates/';
					$template = $obj->smarty->fetch('errors/generic.tpl');
				}
				break;
			default:
				if(file_exists(SITE_ROOT . '/modules/' . $_REQUEST['module'] . '/templates/errors/' . $err . '.tpl')){
					$template = $obj->smarty->fetch('errors/' . $err . '.tpl');
				} else if(file_exists(SITE_ROOT . '/modules/' . $_REQUEST['module'] . '/templates/errors/generic.tpl')){
					$template = $obj->smarty->fetch('errors/generic.tpl');
				} else if(file_exists(SITE_ROOT . '/templates/errors/' . $err . '.tpl')){
					$obj->smarty->template_dir = SITE_ROOT . '/templates/';
					$template = $obj->smarty->fetch('errors/' . $err . '.tpl');
				} else {
					$obj->smarty->template_dir = SITE_ROOT . '/templates/';
					$template = $obj->smarty->fetch('errors/generic.tpl');
				}
				break;
		}
		
		$obj->setPageTitle('Error displaying requested page');
		$obj->smarty->template_dir = $oldTempDir;
		return $template;
	}

}


/* In order to use function chaining (object dereferencing) we need to redefine the compiler class */
class Smarty_Compiler_Norex extends Smarty_Compiler {

    public $_obj_call_regexp = null;
   
    function __construct() {
       $this->Smarty_Compiler();
       
       $this->_obj_call_regexp = '(?:' . $this->_obj_start_regexp . '(?:' . $this->_obj_params_regexp . ''.'(?:' . $this->_obj_ext_regexp . '(?:' . $this->_obj_params_regexp . '|' . $this->_obj_single_param_regexp . '(?:\s*,\s*' . $this->_obj_single_param_regexp . ')*))*' .    ')?(?:' . $this->_dvar_math_regexp . '(?:' . $this->_num_const_regexp . '|' . $this->_dvar_math_var_regexp . ')*)?)';
    }
}

//require_once(SITE_ROOT . '/core/plugins/resource.db.php');
$smarty = new SmartySite();

$config = Config::singleton();

foreach ($config->getActiveModules() as $mod) {
	$smarty->plugins_dir[] = SITE_ROOT . '/modules/' . $mod['module'] . '/plugins';
}

$smarty->assign_by_ref('config', $config);
if (file_exists(SITE_ROOT . '/templates/local')) {
	$smarty->template_dir = SITE_ROOT . '/templates/local';
}
$smarty->compile_dir = SITE_ROOT . '/templates_c';
$smarty->plugins_dir[] = SITE_ROOT . '/core/plugins';

require_once 'Event/Dispatcher.php';
			$global = &Event_Dispatcher::getInstance();
			$global->addObserver(array('Module', 'onSave'), 'onSave');
			$global->addObserver(array('Module', 'onDelete'), 'onDelete');
			$global->addObserver(array('Module', 'onToggle'), 'onToggle');
			$global->addObserver(array('Module', 'onPreSave'), 'onPreSave');
			$global->addObserver(array('Module', 'onPreDelete'), 'onPreDelete');
			$global->addObserver(array('Module', 'onPreToggle'), 'onPreToggle');
?>
