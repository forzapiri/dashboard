<?php


require_once 'PHPUnit/Framework/TestCase.php';

class SQLTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
	}
	
	

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {	
	}

	public function testCoreSQL() {
		$sqlDir = dirname(__FILE__).'/../sql/';
		$dir  = new DirectoryIterator($sqlDir);
		foreach ($dir as $file) {
			$fileName = $file->getFilename();
			if ($fileName == '.svn' || $fileName == '.' || $fileName == '..') {
				continue;
			}
			$sql = file_get_contents($sqlDir . $fileName);
			$r = Database::singleton()->multi_query($sql);
			$this->assertTrue($r);
		}
	}
	
	public function testModuleSQL() {
		$dataDir  = dirname(__FILE__).'/../../modules/';
	
		$dir  = new DirectoryIterator($dataDir);
		foreach ($dir as $file) {
			$fileName = $file->getFilename();
			if (file_exists($dataDir . $fileName . '/schema.sql')) {
				$sql = file_get_contents($dataDir . $fileName . '/schema.sql');
				$r = Database::singleton()->multi_query($sql);
				$this->assertTrue($r);
			}
		}
	}
}

