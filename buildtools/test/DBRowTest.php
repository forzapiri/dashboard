<?php

require_once 'core/PEAR/PHPUnit/Framework/TestCase.php';

/**
 *  test case.
 */
class DBRowTest extends PHPUnit_Framework_TestCase {

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
	// TODO Auto-generated DBRowTest::setUp()
	

	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated DBRowTest::tearDown()
		

		parent::tearDown ();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {	// TODO Auto-generated constructor
	}
	
	public function testMake() {
		$row = DBRow::make(null, 'User');
		$this->assertNull($row->get('id'));
		
		$row = DBRow::make(1, 'User');
		$this->assertEquals($row->get('id'), 1);
		$this->assertType('User', $row);
	}
	
	public function test__call() {
		$row = DBRow::make(1, 'User');
		$this->assertNull(@$row->failfailfail());
	}
	
	public function testCamelCase() {
		$this->assertEquals('MenuItem', Inflector::camelize('menu_item'));
		$this->assertEquals('TestId', Inflector::camelize('test_id'));
		$this->assertEquals('MenuItem', Inflector::camelize('MenuItem'));
		$this->assertEquals('Test_', Inflector::camelize('test_'));
	}
	
	public function testCreateTable() {
		$t = DBRow::createTable('auth', 'User');
		$this->assertType('DBTable', $t); 
		$this->assertNull($t->columns());
	}
	
	public function testToggle() {
		$row = DBRow::make(1, 'User');
		$this->assertEquals(true, $row->get('status'));
		$row->toggle();
		$this->assertEquals(false, $row->get('status'));
		$row->toggle();
		$this->assertEquals(true, $row->get('status'));
	}

}

