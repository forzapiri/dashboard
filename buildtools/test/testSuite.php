<?php

require_once(dirname(__FILE__) . '/../../include/Site.php');

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'UITest.php';

require_once 'DatabaseTest.php';
require_once 'UserTest.php';
require_once 'AddressTest.php';
require_once 'ImageTest.php';
require_once 'GroupTest.php';
require_once 'DBTableTest.php';
require_once 'DBColumnsTest.php';
require_once 'DBRowTest.php';

/**
 * Static test suite.
 */
class testSuite extends PHPUnit_Framework_TestSuite {

	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$sqlDir = dirname(__FILE__).'/../sql/';
		$dir  = new DirectoryIterator($sqlDir);
		foreach ($dir as $file) {
			$fileName = $file->getFilename();
			if ($fileName == '.svn' || $fileName == '.' || $fileName == '..') {
				continue;
			}
			$sql = file_get_contents($sqlDir . $fileName);
			Database::singleton()->multi_query($sql);
		}
		
		
		$this->setName ( 'testSuite' );
		
		$this->addTestSuite ( 'DBRowTest' );
		$this->addTestSuite ( 'DBColumnTest' );
		$this->addTestSuite ( 'DatabaseTest' );
		$this->addTestSuite ( 'DBTableTest' );
		$this->addTestSuite ( 'UserTest' );
		$this->addTestSuite ( 'AddressTest' );
		$this->addTestSuite ( 'ImageTest' );
		$this->addTestSuite ( 'GroupTest' );

		$dataDir  = dirname(__FILE__).'/../../modules/';
	
		$dir  = new DirectoryIterator($dataDir);
		foreach ($dir as $file) {
			$fileName = $file->getFilename();
			if (file_exists($dataDir . $fileName . '/tests')) {
				$tests  = new DirectoryIterator($dataDir . $fileName . '/tests/');
				foreach ($tests as $test) {
					$testName = $test->getFilename();
					if ($testName == '.svn' || $testName == '.' || $testName == '..') {
						continue;
					}
					require_once($dataDir . $file . '/tests/' . $testName);
					//$this->addTestSuite ( trim($testName, '.php') );
				}
			}
			if (file_exists($dataDir . $fileName . '/schema.sql')) {
				$sql = file_get_contents($dataDir . $fileName . '/schema.sql');
				Database::singleton()->multi_query($sql);
			}
		}
	}

	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}

