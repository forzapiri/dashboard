<?php
// Call GroupTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'GroupTest::main');
}

require_once 'PHPUnit/Framework.php';

require_once 'Group.php';
require_once 'PHPUnit/Framework/TestCase.php';
/**
 * Test class for Group.
 * Generated by PHPUnit on 2008-04-27 at 14:54:35.
 */
class GroupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    Group
     * @access protected
     */
    protected $object;
    protected $stub;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
    	parent::setUp ();
        $this->object = Group::make();
        $this->stub = $this->getMock('Notification', array('getNotificationObject'));
        $this->stub->expects($this->any())
             ->method('getNotificationObject')
             ->will($this->returnValue(&$this->object));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	$this->object->delete();
    	parent::tearDown ();
    	ob_end_flush();
    }
    
	public function __construct() {	
		ob_start();
	}

    /**
     * @todo Implement testGetName().
     */
    public function testGetName() {
    	$this->object->setName('testgroup');
    	$this->assertEquals($this->object->getName(), 'testgroup');
    }

    /**
     * @todo Implement testGetId().
     */
    public function testGetId() {
    	$this->object->setName('testgroup');
    	$this->object->save(&$this->stub);
    	
    	if (is_null($this->object->getId())) {
    		$this->fail();
    	}
    }

    /**
     * @todo Implement testSetName().
     */
    public function testSetName() {
        $this->object->setName('testgroup');
        $this->assertEquals($this->object->getName(), 'testgroup');
    }

    /**
     * @todo Implement testSave().
     */
    public function testSave() {
        $this->object->setName('testgroup');
        $this->object->save(&$this->stub);
        
    	if (is_null($this->object->getId())) {
    		$this->fail();
    	}
    	
    	$this->assertEquals($this->object, Group::make($this->object->getId()));
    	
    	$this->object->setName('testgroup2');
    	$this->object->save(&$this->stub);
    	
    	$this->assertEquals($this->object, Group::make($this->object->getId()));
    }

    /**
     * @todo Implement testDelete().
     */
    public function testDelete() {
		$this->object->setName('testgroup');
		$this->object->save(&$this->stub);
    	$this->object->delete(&$this->stub);
        $this->assertEquals(Group::make(), Group::make($this->object->getId()));
    }
    
    /**
     * @todo Implement testGetAddEditForm().
     */
    public function testGetAddEditForm() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testGetGroups().
     */
    public function testGetGroups() {
        $groups = Group::getAll();
        if (!is_array($groups)) {
        	$this->fail();
        }
        
        foreach ($groups as $group) {
        	if (!($group instanceof Group)) $this->fail();
        }
    }
}

?>
