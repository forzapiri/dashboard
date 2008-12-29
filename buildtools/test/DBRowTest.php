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
		$row = DBRow::make('User', null);
		$this->assertNull($row->get('id'));
		
		$row = DBRow::make('User', 1);
		$this->assertEquals($row->get('id'), 1);
		$this->assertType('User', $row);
	}
	
	public function test__call() {
		$row = DBRow::make('User', 1);
		$this->assertNull($row->failfailfail());
	}

}

