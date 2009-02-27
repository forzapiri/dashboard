<?php
 
class MenuAdminUITest extends UITest
{
 
	protected $stub = null;
	
    protected function setUp()
    {
    	//require_once(dirname(__FILE__) . '/../include/MenuItem.php');
    	/*foreach (MenuItem::getAll() as $item) {
	        $item->delete();
    	}*/
        $this->setBrowserUrl('http://trunk/');
    }
    
    public function testCreate() {
    	$this->doLogin();
    	$this->open('http://trunk/admin/Menu');
    	
    	$this->assertTextPresent('Menu');
    	
    	$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
        return;
    	
    	//create
    	$this->click("link=Create Menu Item");
    	$this->assertFaceBoxVisible();
	    $this->type("menuitem_display", "Test Item");
	    $this->select("menuitem_parent_id", "label=Home Page");
	    $this->click("menuitem_submit");
	    $this->assertFaceBoxHidden();
	    
	    //toggle
	    $this->click('//tr/td/div[@class="menuItemName"][text()="Test Item"]/../../td[4]/form/input[4]');
	    sleep(1);
	    $this->click('//tr/td/div[@class="menuItemName"][text()="Test Item"]/../../td[4]/form/input[4]');
	    
	    
	    $this->click('//tr/td/div[@class="menuItemName"][text()="Test Item"]/../../td[5]/form[1]/input[4]');
	    $this->assertFaceBoxVisible();
	    $this->type("menuitem_display", "Edited Item");
	    $this->select("menuitem_parent_id", "label=[ Top Level Item ]");
	    $this->click("menuitem_submit");
	    $this->assertFaceBoxHidden();
	    
	    $this->chooseCancelOnNextConfirmation();
    	$this->click('//tr/td/div[@class="menuItemName"][text()="Edited Item"]/../../td[5]/form[2]/input[4]');
    	$this->assertConfirmationPresent();
    	$this->getConfirmation();
    	$this->assertTextPresent('Edited Item');
    	sleep(1);
    	$this->chooseOkOnNextConfirmation();
    	$this->click('//tr/td/div[@class="menuItemName"][text()="Edited Item"]/../../td[5]/form[2]/input[4]');
    	$this->assertConfirmationPresent();
    	$this->getConfirmation();
    	
    	sleep(1);
    	$this->assertTextNotPresent('Edited Item');

    }
    
    public function testTemplate() {
    	$this->doLogin();
    	
    	$this->open('http://trunk/admin/Menu');
    	
    	$this->assertTextPresent('Menu');
    	$this->assertTextNotPresent('Main Navigation Menu Test');
    	
		$this->click("link=Menu Template");
		$this->assertFaceBoxVisible();
		$this->type("name", "Main Navigation Menu Test");
		$this->click("submit");
		$this->assertFaceBoxHidden();
		$this->assertTextPresent('Main Navigation Menu Test');
		
		$this->click("link=Menu Template");
		$this->assertFaceBoxVisible();
		$this->type("name", "Main Navigation Menu");
		$this->click("submit");
		
		$this->assertFaceBoxHidden();
    	$this->assertTextPresent('Main Navigation Menu');
    	$this->assertTextNotPresent('Main Navigation Menu Test');
    }
    
    /* http://bugs.norex.ca/view.php?id=97
     * Facebox border and background missing after invalid form submit
     */
    
    public function testBug97() {
    	$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
        return;
    	$this->doLogin();
    	
    	$this->open('http://trunk/admin/Menu');
    	
    	$this->click("link=Create Menu Item");
    	$this->assertFaceBoxVisible();
    	$this->click("menuitem_submit");
    	$this->assertFaceBoxVisible();
    	$this->assertElementPresent('css=div#facebox div.content');
    }

}
