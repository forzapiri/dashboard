<?php
class ECommShipping{
	protected $shippingName = '';
	protected $shippingDetails = '';
	private static $activeShippingPlugin = array();
	private static $defaultPlugin;
	public function __construct(){
	}
	
	//This function calculates the shipping cost. It has two optional parameters: sessionId and cartItems
	//If sessionId is null, we take the current session.
	//We don't need cartItems to be passed as a parameter because we can always get the cart items based on the session ID.
	//However, if we have already quiried the cart items, it is a good idea to pass them here for performance purposes
	public function getShippingCost($sessionId = null, $cartItems = null){
		$session = Session::getActiveSession($sessionId);
		$sessionId = $session->getId();
		if (!is_array($cartItems))
			$cartItems = CartItem::getAll($sessionId);
		return $this->calculateCost($session, $cartItems);
	}
	
	//This method should be overridden by all the plugins
	public function calculateCost($session, $cartItems){
		return 0.00;
	}
	
	public function getShippingName(){
		return $this->shippingName;
	}
	
	public function getShippingDetails(){
		return $this->shippingDetails;
	}
	
	//This method only returns the IDs of the plugins
	public function getActivePluginIDs(){
		$myActivePlugin = array();
		foreach (ECommShipping::$activeShippingPlugin as $key => $val){
			array_push($myActivePlugin, $key);
		}
		return $myActivePlugin;
	}
	
	public function getPlugin($className){
		if (!isset(ECommShipping::$activeShippingPlugin[$className])){
			//If $className does not exist as a plugin, return the default class
			//If the default class does not exist, return the $this pointer to be the default shipping class
			if (ECommShipping::getDefaultPlugIn())
				return $this->getPlugin(ECommShipping::getDefaultPlugIn());
			return $this;
		}
		return ECommShipping::$activeShippingPlugin[$className];
	}
	
	public static function getDefaultPlugIn(){
		return ECommShipping::$defaultPlugin;
	}
	
	//This function initializes the shipping classes
	public static function init($className, $isActive = true, $isDefault=false){
		//If the $isActive parameter is false, do not do anything. This will be useful if we store the plugins in the database
		//The $isDefault parameter will change the default shipping plugin
		if (!$isActive)
			return;
		if (!isset(ECommShipping::$activeShippingPlugin[$className])){
			require "$className.php";
			ECommShipping::$activeShippingPlugin[$className] = new $className();
		}
		//If this is the first plugin, make it the default one
		if (count(ECommShipping::$activeShippingPlugin) == 1)
			$isDefault = true;
		if ($isDefault){
			//If a plugin is the default shipping class:
			//First, set the defaultPlugin variable to the name of this class
			//Second, change the order of the array becuase the default plugin MUST always be the first shipping plugin
			ECommShipping::$defaultPlugin = $className;
			$tempArray = ECommShipping::$activeShippingPlugin;
			ECommShipping::$activeShippingPlugin = array();
			ECommShipping::$activeShippingPlugin[$className] = $tempArray[$className];//Put the default plugin at the beginning
			foreach ($tempArray as $key => $val){
				ECommShipping::$activeShippingPlugin[$key] = $val;
			}
		}
	}
	
	//Override the following function to administer the shipping price
	//The $ECommModule variable represents the module object in case you need to use ->addCSS or ->smarty
	public function getAdminInterface($ECommModule){
		return "This plugin does not have any admin interface";
	}
}
ECommShipping::init("CanadaPost");
ECommShipping::init("FedEx",false);
ECommShipping::init("NewMethod",false);
ECommShipping::init("EAndA",false);
?>