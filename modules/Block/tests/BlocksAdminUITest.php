<?php
 
class BlocksAdminUITest extends UITest
{
 
	protected $stub = null;
	
    protected function setUp()
    {
    	require_once(dirname(__FILE__) . '/../include/Block.php');
    	foreach (Block::getAllBlocks() as $block) {
	        $block->delete();
    	}
        $this->setBrowserUrl('http://trunk/');
    }
    
    public function testCreate() {
    	$this->doLogin();
    	$this->open('http://trunk/admin/Block');
    	
    	$this->assertTextPresent('Blocks');
    	$this->assertTextPresent('No Blocks Created');
    	
    	$this->clickAndWait("link=make one");
    	$this->type("blocks_title", "Initial Block");
    	$this->waitForCondition("selenium.browserbot.getCurrentWindow().tinyMCE.getInstanceById( 'blocks_content').setContent('This is a test'); true", "5000");
	    	
    	$this->clickAndWait("blocks_submit");
    	
    	// Create
    	$this->click("link=Create Block");
    	$this->assertFaceBoxVisible();
    	$this->waitForCondition("window.document.getElementById('blocks_title') != null", "5000");

    	$this->type("blocks_title", "Test Block");
    	sleep(2);
    	$this->waitForCondition("selenium.browserbot.getCurrentWindow().tinyMCE.getInstanceById( 'blocks_content').setContent('This is a test'); true", "5000");
	    	
    	$this->click("blocks_submit");
    	$this->assertFaceBoxHidden();

    	$this->assertTextPresent('Test Block');
    	
    	// Test Activate
    	sleep(1);
    	$this->click('//*/table/tbody/tr/td[text()="Test Block"]/../td[3]/form[1]/input[4]');
    	sleep(1);
    	$this->click('//*/table/tbody/tr/td[text()="Test Block"]/../td[3]/form[1]/input[4]');
    	
    	// Test Edit
    	$this->click('//*/table/tbody/tr/td[text()="Test Block"]/../td[4]/form[1]/input[4]');
    	$this->assertFaceBoxVisible();
    	$this->waitForCondition("window.document.getElementById('blocks_title') != null", "5000");
    	
    	
    	$this->type("blocks_title", "Edited Block");
    	$this->click("blocks_submit");
    	$this->assertFaceBoxHidden();

    	$this->assertTextPresent('Edited Block');
    	
    	// Test Delete
    	$this->chooseOkOnNextConfirmation();
    	$this->click('xpath=//*/table/tbody/tr/td[text()="Initial Block"]/../td[4]/form[2]/input[4]');
    	$this->assertConfirmationPresent();
    	$this->getConfirmation();
		sleep(1);
    	$this->chooseCancelOnNextConfirmation();
    	$this->click('xpath=//*/table/tbody/tr/td[text()="Edited Block"]/../td[4]/form[2]/input[4]');
    	$this->assertConfirmationPresent();
    	$this->getConfirmation();
    	sleep(1);
    	$this->chooseOkOnNextConfirmation();
    	$this->click('xpath=//*/table/tbody/tr/td[text()="Edited Block"]/../td[4]/form[2]/input[4]');
    	$this->assertConfirmationPresent();
    	$this->getConfirmation();
    	
    	sleep(2);
    	$this->assertTextPresent('No Blocks Created');
    }

}
?>