<?php
require "ECommProduct_interface.php";
class ECommProduct{
	protected $pluginName = '';
	protected $pluginDetails = '';
	private static $activeProductPlugin = array();
	public function __construct(){
	}
	
	public function getPluginName(){
		return $this->pluginName;
	}
	
	public function getPluginDetails(){
		return $this->pluginDetails;
	}
	
	//This method only returns the IDs of the plugins
	public function getActivePluginIDs(){
		$myActivePlugin = array();
		foreach (ECommProduct::$activeProductPlugin as $key => $val){
			array_push($myActivePlugin, $key);
		}
		return $myActivePlugin;
	}
	
	public function getPlugin($className){
		if (!isset(ECommProduct::$activeProductPlugin[$className])){
			//If $className does not exist as a plugin, generate an error
			trigger_error("Plugin does not exist or has not been initialized", E_USER_ERROR);
			return false;
		}
		return ECommProduct::$activeProductPlugin[$className];
	}
	
	//This function initializes the Product classes
	public static function init($className, $isActive = true){
		//If the $isActive parameter is false, do not do anything. This will be useful if we store the plugins in the database
		if (!$isActive)
			return;
		if (!isset(ECommProduct::$activeProductPlugin[$className])){
			require "$className.php";
			ECommProduct::$activeProductPlugin[$className] = new $className();
		}
	}
	
	public static function adminPluginHooks(){
		$args = func_get_args();
		$hookName = @$args[0];
		$product = @$args[1];
		$form = @$args[2];
		$hookResults = array();
		$abort = false;
		foreach (ECommProduct::$activeProductPlugin as $key => $val){
			$pluginResult = call_user_func(array($val, "adminHook" . $hookName), $product, $form);
			$hookResults[$key] = $pluginResult;
			if (is_array($pluginResult) && @$pluginResult["abort"]){
				$abort = true;
				$abortMsg = @$pluginResult["msg"];
				break;
			}
		}
		if ($abort){//One of the plugins raised a red flag. Do not proceed
			$abortMsg = urlencode($abortMsg);
			$abortMsg = str_replace("%","%25", $abortMsg);//The % sign should be replaced with %25 so Apache rewrite rules will work properly
			header('location: /admin/EComm&section=Product&msg=' . $abortMsg);
			exit; 
		}
		return $hookResults;
	}
	
	public static function clientPluginHooks(){
		$args = func_get_args();
		$hookName = @$args[0];
		$param = @$args[1];
		$ecommModule = @$args[2];
		$hookResults = array();
		$abort = false;
		foreach (ECommProduct::$activeProductPlugin as $key => $val){
			$pluginResult = call_user_func(array($val, "clientHook" . $hookName), $param, $ecommModule);
			$hookResults[$key] = $pluginResult;
			if (is_array($pluginResult) && @$pluginResult["abort"]){
				$abort = true;
				$abortMsg = @$pluginResult["msg"];
				$abortURL = @$pluginResult["url"];
				break;
			}
		}
		if ($abort){//One of the plugins raised a red flag. Do not proceed
			$abortMsg = urlencode($abortMsg);
			$abortMsg = str_replace("%","%25", $abortMsg);//The % sign should be replaced with %25 so Apache rewrite rules will work properly
			if (!$abortURL)
				$abortURL = '/Store/Category/';
			header('location: ' . $abortURL . '&msg=' . $abortMsg);
			exit; 
		}
		return $hookResults;
	}
	
	public static function getPluginsPrice($cartItem){
		$result = 0.00;
		foreach (ECommProduct::$activeProductPlugin as $key => $val){
			$pluginPrice = $val->calculatePrice($cartItem);
			if ($pluginPrice)
				$result += (float)$pluginPrice;
		}
		return $result;
	}
}
foreach(SiteConfig::get("EComm::productPlugins") as $plugin){
	ECommProduct::init($plugin);
}
?>