<?php

require_once 'core/Database.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Database test case.
 */
class DatabaseTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Database
	 */
	private $Database;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->Database = Database::singleton();
	
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Database = null;
		
		parent::tearDown ();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {	}

	/**
	 * Tests Database->fetch()
	 */
	public function testFetch() {
		$obj = $this->Database->query('select 1');
		$result = ($this->Database->fetch($obj));
		if (!$result[1] == 1) {
			$this->fail();
		}
	}

	/**
	 * Tests Database->fetch_all()
	 */
	public function testFetch_all() {
		$obj = $this->Database->query('select * from templates');		
		$result = ($this->Database->fetch_all($obj));
		if (count($result) < 2) {
			$this->fail();
		}
	}

	/**
	 * Tests Database->lastInsertedID()
	 */
	public function testLastInsertedID() {
		if (!is_numeric($this->Database->lastInsertedID())) {
			$this->fail();
		}
	}

	/**
	 * Tests Database->query()
	 */
	public function testQuery() {
		if (get_class($this->Database->query('select 1')) != 'mysqli_result') {
			$this->fail();
		}
	}

	/**
	 * Tests Database->query_fetch()
	 */
	public function testQuery_fetch() {
		$result = ($this->Database->query_fetch('select 1'));
		if (!$result[1] == 1) {
			$this->fail();
		}
	
	}

	/**
	 * Tests Database->query_fetch_all()
	 */
	public function testQuery_fetch_all() {
		$result = ($this->Database->query_fetch_all('select * from templates'));
		if (count($result) < 2) {
			$this->fail();
		}
	}

	/**
	 * Tests Database::singleton()
	 */
	public function testSingleton() {
		if (is_object(Database::singleton())) {
			return;
		} else {
			$this->fail('singleton method does not return object');
		}
	}

	/**
	 * Tests Database->__clone()
	 */
	public function test__clone() {
		// TODO Auto-generated DatabaseTest->test__clone()
		/*try {
			clone($this->Database);
		} catch (Exception $e) {
			return;
		}
		$this->fail('Should not be able to clone object'); */
		return;
	}

	/**
	 * Tests Database->__sleep()
	 */
	public function test__sleep() {
		if (!is_array($this->Database->__sleep(/* parameters */))) {
			$this->fail();
		}
	
	}

	/**
	 * Tests Database->__wakeup()
	 */
	public function test__wakeup() {
		if ($this->Database->__wakeup() != '') {
			$this->fail();
		}
	}

}

