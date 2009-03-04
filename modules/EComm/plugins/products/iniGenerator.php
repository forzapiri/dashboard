<?php 
class iniGenerator extends ECommProduct{
	public function __construct(){
		$this->pluginName = ".ini file generator";
		$this->pluginDetails = "Generates the .ini file for the user after they purchase and download the product";
	}
	
	public function clientHookBeforeDisplay(&$product, &$ecommModule){
		$html = "<h1>.ini file generator</h1>";
		return (array(
					//'abort'=> '1', 
					//'msg' => 'hi there',
					'HTML' => $html 
				));
	}
	
}

?>