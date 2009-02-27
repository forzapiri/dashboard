<?php
 
class UserUITest extends UITest
{
 
    protected function setUp()
    {
        $this->setBrowserUrl('http://trunk/');
    }
 
    public function testCreate() {
    	$this->doLogin();
    	$this->open('http://trunk/admin/User');
    	
    	$this->assertTextPresent('User Management');
    	
    	$this->click('xpath=id(\'primary\')/li/a');
    	$this->assertFaceBoxVisible();
    	sleep(3);
    	
    	$this->assertTextPresent('Username');
        $this->assertTextPresent('Password');
        
        $this->type('user_username', 'testuser');
        $this->type('user_password', 'testpass');
        $this->type('user_name', 'Unit Testing User');
        $this->type('user_email', 'test@norex.ca');
        $this->select('user_group','label=Administrator');
        $this->check('user_status');
        $this->click('user_submit');
        $this->assertFaceBoxHidden();
        
        $this->assertTextPresent('testuser');
        
        
        // Test Edit
    	$this->click('xpath=//*/table/tbody/tr/td[1][text()="testuser"]/../td[7]/form[1]/input[4]');
    	$this->assertFaceBoxVisible();
    	$this->click("user_submit");
    	$this->assertFaceBoxHidden();
    	sleep(1);

        // Test Delete
    	$this->chooseOkOnNextConfirmation();
    	$this->click('xpath=//*/table/tbody/tr/td[1][text()="testuser"]/../td[7]/form[2]/input[4]');
    }
}
