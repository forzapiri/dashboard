<?php
class ECommPayment{
	protected $paymentName = '';
	protected $paymentDetails = '';
	private static $activePaymentPlugin = array();
	private static $defaultPlugin;
	public function __construct(){
	}
	
	public function getPaymentName(){
		return $this->paymentName;
	}
	
	public function getPaymentDetails(){
		return $this->paymentDetails;
	}
	
	//This method displays the right forms for each payment option
	public function getPaymentForm(){
		return "";
	}
	
	//This method does the actual payment.
	//For example, it will be called when PayPal IPN arrives, or when the credit card is charged
	public function doPayment(){
		return true;
	}
	
	//This method only returns the IDs of the plugins
	public function getActivePluginIDs(){
		$myActivePlugin = array();
		foreach (ECommPayment::$activePaymentPlugin as $key => $val){
			array_push($myActivePlugin, $key);
		}
		return $myActivePlugin;
	}
	
	public function getPlugin($className){
		if (!isset(ECommPayment::$activePaymentPlugin[$className])){
			//If $className does not exist as a plugin, return the default class
			//If the default class does not exist, return the $this pointer to be the default payment class
			if (ECommPayment::getDefaultPlugIn())
				return $this->getPlugin(ECommPayment::getDefaultPlugIn());
			return $this;
		}
		return ECommPayment::$activePaymentPlugin[$className];
	}
	
	public static function getDefaultPlugIn(){
		return ECommPayment::$defaultPlugin;
	}
	
	//This function initializes the payment classes
	public static function init($className, $isActive = true, $isDefault=false){
		//If the $isActive parameter is false, do not do anything. This will be useful if we store the plugins in the database
		//The $isDefault parameter will change the default payment plugin
		if (!$isActive)
			return;
		if (!isset(ECommPayment::$activePaymentPlugin[$className])){
			require "$className.php";
			ECommPayment::$activePaymentPlugin[$className] = new $className();
		}
		//If this is the first plugin, make it the default one
		if (count(ECommPayment::$activePaymentPlugin) == 1)
			$isDefault = true;
		if ($isDefault){
			//If a plugin is the default payment class:
			//First, set the defaultPlugin variable to the name of this class
			//Second, change the order of the array becuase the default plugin MUST always be the first payment plugin
			ECommPayment::$defaultPlugin = $className;
			$tempArray = ECommPayment::$activePaymentPlugin;
			ECommPayment::$activePaymentPlugin = array();
			ECommPayment::$activePaymentPlugin[$className] = $tempArray[$className];//Put the default plugin at the beginning
			foreach ($tempArray as $key => $val){
				ECommPayment::$activePaymentPlugin[$key] = $val;
			}
		}
	}
}
ECommPayment::init("Paypal");
ECommPayment::init("CreditCard",false);
ECommPayment::init("NewPaymentMethod",false);
?>