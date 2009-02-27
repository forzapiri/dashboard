<?
class Module_Splash extends Module {
	function getUserInterface($params){
		$this->parentSmarty->templateOverride('db:splash.tpl');
		return true;
	}
}
?>