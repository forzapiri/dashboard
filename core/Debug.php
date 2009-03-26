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
