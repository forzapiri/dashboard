<?php

require_once 'core/User.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * User test case.
 */
class UserTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var User
	 */
	private $User;

	private $stub;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		$this->User = User::make();
		$this->stub = $this->getMock('Notification', array('getNotificationObject'));
        $this->stub->expects($this->any())
             ->method('getNotificationObject')
             ->will($this->returnValue(&$this->User));
             
		//$this->User->save(&$this->stub);
	}
	
	

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated UserTest::tearDown()
		$this->User->delete();
		$this->User = null;
		
		parent::tearDown ();
		ob_end_flush();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {	
		ob_start();
	}

	/**
	 * Tests User->__construct()
	 */
	public function test__construct() {
		$this->User->__construct();
		$this->assertEquals(get_class($this->User), 'User');
	}
	
	public function testGetId() {
		$this->User->setUsername('testuser');
		$this->User->save();
		
		$this->assertNotNull($this->User->getId());
		if (!is_numeric($this->User->getId())) {
			$this->fail();
		}
	}
	
	public function testSave() {
		
		$this->User->setUsername('testuser');
		$this->User->setPassword('testpassword');
		$this->User->save(&$this->stub);
		if (!$this->User->save()) {
			$this->fail();
		}
	}

	public function testSetId() {
		$oldid = $this->User->getId();
		$this->User->setId(666);
		$this->assertEquals($this->User->getId(), 666);
		$this->User->setId($oldid);
	}
	
	public function testGetName() {
		$this->assertEquals($this->User->getName(), null);
		$this->User->setName('testuser');
		$this->assertEquals($this->User->getName(), 'testuser');
	}
	
	public function testGetUsername() {
		$this->assertEquals($this->User->getUsername(), null);
		$this->User->setUsername('testuser');
		
		$this->assertEquals($this->User->getUsername(), 'testuser');
	}
	
	public function testGetEmail() {
		$this->assertEquals($this->User->getEmail(), null);
		$this->User->setEmail('test@norex.ca');
		
		$this->assertEquals($this->User->getEmail(), 'test@norex.ca');
	}
	
	public function testGetStatus() {
		$this->assertEquals($this->User->getStatus(), null);
		$this->User->setStatus(1);
		
		$this->assertEquals($this->User->getStatus(), 1);
	}
	
	public function testGetAuthGroup() {
		$this->assertEquals($this->User->getGroup(), null);
		$this->User->setGroup(1);
		
		$this->assertEquals($this->User->getGroup(), 1);
	}
	
	public function testGetAllUsers() {
		if (!is_array(User::getAll())) {
			$this->fail();
		}
	}
	
	public function testHasPerm() {
		$this->User->setGroup(1);
		$this->User->save();
		
		$this->assertTrue(!!$this->User->hasPerm('CMS', 'admin'));
		$this->assertFalse(!!$this->User->hasPerm('CMS', 'made_up_permission_string'));
	}
	
	public function testQuickFormPrefix() {
		$this->assertEquals('user_', $this->User->quickformPrefix());
	}
	
	public function testToArray() {
		$a = User::toArray();
		$this->assertArrayHasKey(1, $a);
	}
	
	public function testCreateTable() {
		$t = User::createTable();
		$this->assertType('DBTable', $t);
	}
}

