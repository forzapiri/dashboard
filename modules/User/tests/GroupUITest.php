<?php

class GroupUITest extends UITest
{
 
    protected function setUp()
    {
        $this->setBrowserUrl('http://trunk/');
    }
    
    public function testCreate() {
    	$this->doLogin();
    	$this->open('http://trunk/admin/User&section=Group');
    	
    	$this->assertTextPresent('User Management');
    	
    	$this->click('link=Create Group');
    	$this->assertFaceBoxVisible();
    	
    	$this->assertTextPresent('Group Name');
        
        $this->type('group_name', 'Test Group');
        $this->click('group_submit');
        $this->assertFaceBoxHidden();
        
        $this->assertTextPresent('Test Group');
        
        // Test Edit
    	$this->click('xpath=//*/table/tbody[1]/tr[3]/td[3]/form[1]/input[4]');
    	$this->assertFaceBoxVisible();
    	$this->type('group_name', 'Edited Group');
    	$this->click("group_submit");
    	
    	$this->assertFaceBoxHidden();
    	$this->assertTextPresent('Edited Group');

        // Test Delete
    	$this->chooseOkOnNextConfirmation();
    	$this->click('xpath=//*/table/tbody[1]/tr[3]/td[3]/form[2]/input[4]');
    	sleep(1);
    	$this->assertTextNotPresent('Edited Group');
    }
    
    public function testGroupUser() {
    	$this->doLogin();
    	$this->open("http://trunk/admin/User");
    	
    	$this->click('link=Create User');
		$this->assertFaceBoxVisible();
		$this->type("user_username", "testuser");
		$this->type("user_password", "testpassword");
		$this->type("user_name", "Test User");
		$this->type("user_email", "test@norex.ca");
		$this->click("user_submit");
		$this->assertFaceBoxHidden();
		$this->assertEquals("testuser", $this->getText("//*/table/tbody/tr[3]/td[1]"));
		$this->assertEquals("Administrator", $this->getText("//*/table/tbody/tr[3]/td[5]"));
		$this->clickAndWait("link=Group Management");
		$this->click('link=Create Group');
		$this->assertFaceBoxVisible();
		$this->type("group_name", "Test Group");
		$this->click("group_submit");
		$this->assertFaceBoxHidden();
		$this->assertEquals("Test Group", $this->getText("//*/table/tbody/tr[3]/td[1]"));
		$this->assertEquals("0", $this->getText("//*/table/tbody/tr[3]/td[2]"));
		$this->clickAndWait("link=User Management");
		$this->click("//*/table/tbody/tr[3]/td[7]/form[1]/input[4]");
		$this->assertFaceBoxVisible();
		$this->select("user_group", "label=Test Group");
		$this->click("user_submit");
		$this->assertFaceBoxHidden();
		$this->assertEquals("Test Group", $this->getText("//*/table/tbody/tr[3]/td[5]"));
		$this->clickAndWait("link=Group Management");
		$this->click("//*/table/tbody/tr[3]/td[3]/form[2]/input[4]");
		$this->assertConfirmationPresent();
    	$this->getConfirmation();
		$this->clickAndWait("link=User Management");
		$this->click("//*/table/tbody/tr[3]/td[4]");
		$this->assertEquals("", $this->getText("//*/table/tbody/tr[3]/td[5]"));
		$this->click("//*/table/tbody/tr[3]/td[7]/form[2]/input[4]");
		$this->assertConfirmationPresent();
    	$this->getConfirmation();
		    	
    }
}
