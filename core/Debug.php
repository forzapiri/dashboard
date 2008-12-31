<?php

class Debug {
	
	private static $instance;
	private $messages = array('Debug Messages', array(array('SQL Query', 'MySQL Results', 'Type Of Message')));
	
	private function __construct() {
		
	}
	
	public static function singleton() {
		if (! isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c();
		}
		
		return self::$instance;
	}
	
	public function getMessages() {
		return $this->messages;
	}
	
	public function addMessage($title, $m, $type = 'message') {
  
  		$cur =& $this->messages[1][];
  		$cur = array(str_replace("\n", '',$title), str_replace("\n", '',$m), $type);
		
	}
	
	public function __toString() {
		$smarty = new SmartySite();
		if (file_exists(SITE_ROOT . '/templates/local')) {
			$smarty->template_dir = SITE_ROOT . '/templates/local';
		}
		$smarty->compile_dir = SITE_ROOT . '/cache';
		$smarty->plugins_dir[] = SITE_ROOT . '/core/plugins';
		
		$string = '<script type="text/javascript">
		// <![CDATA[
		    if ( self.name == \'\' ) {
		       var title = \'Console\';
		    }
		    else {
		       var title = \'Console_\' + self.name;
		    }
		    _smarty_console = window.open("",title.value,"width=780,height=600,resizable,scrollbars=yes");' . "\n";

		$smarty->assign('messages', $this->messages);
		$c = $smarty->fetch('debug.tpl');
		$c = str_replace("\n", '', $c);
		$string .= '_smarty_console.document.write(\'' . $c . '\');
		    _smarty_console.document.close();
		// ]]>
		</script>\'';
		
		
		return $string;
	}
	
}

?>