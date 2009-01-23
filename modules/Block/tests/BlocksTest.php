<?php

require_once 'modules/Block/include/Block.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Database test case.
 */
class BlocksTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Database
	 */
	private $Block;
	
	private $stub;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->Block = new Block();
	
		$this->stub = $this->getMock('Notification', array('getNotificationObject'));
        $this->stub->expects($this->any())
             ->method('getNotificationObject')
             ->will($this->returnValue(&$this->Block));
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Block->delete(&$this->stub);
		
		parent::tearDown ();
	}
	
	public function test__construct() {
		$this->Block->__construct();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {	}
}

