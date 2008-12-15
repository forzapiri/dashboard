<?php 

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class UITest extends PHPUnit_Extensions_SeleniumTestCase {
    	
	protected $coverageScriptUrl = 'http://trunk/phpunit_coverage.php';
	
    public static $browsers = array(
      array(
        'name'    => 'Firefox on MacOS X',
        'browser' => 'Firefox on OS X',
        'host'    => 'localhost',
        'port'    => 8888,
        'timeout' => 30000,
      )/*,
      array(
        'name'    => 'Internet Explorer 6 on Windows XP',
        'browser' => '*iexplore',
        'host'    => '192.168.6.40',
        'port'    => 2222,
        'timeout' => 30000,
      ),
      array(
        'name'    => 'Safari on MacOS X',
        'browser' => '*safari',
        'host'    => 'localhost',
        'port'    => 4444,
        'timeout' => 30000,
      )*/
    );
    
	protected function doLogin() {
    	$this->open('http://trunk/admin/');
    	$this->type('username', 'norex');
        $this->type('password', 'D3vP@ss');
        
        $this->clickAndWait("doLogin");
    }
    
    protected function assertFaceBoxHidden() {
    	$this->waitForCondition("!selenium.browserbot.getCurrentWindow().$('facebox').visible()", "5000");
    	$this->assertNotVisible('facebox');
    	sleep(1);
    }
    
    protected function assertFaceBoxVisible() {
    	$this->waitForCondition("selenium.browserbot.getCurrentWindow().$('facebox').visible()", "5000");
    	$this->assertVisible('facebox');
    	sleep(1);
    }
}
?>
