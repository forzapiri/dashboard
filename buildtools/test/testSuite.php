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
require_once 'SQLTest.php';

/**
 * Static test suite.
 */
class testSuite {

	/**
	 * Creates the suite.
	 */
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('Dashboard Test Suite');
		
		$suite->addTestSuite ( 'SQLTest' );
		
		$suite->addTestSuite ( 'DBRowTest' );
		$suite->addTestSuite ( 'DBColumnTest' );
		$suite->addTestSuite ( 'DatabaseTest' );
		$suite->addTestSuite ( 'DBTableTest' );
		$suite->addTestSuite ( 'UserTest' );
		$suite->addTestSuite ( 'AddressTest' );
		$suite->addTestSuite ( 'ImageTest' );
		$suite->addTestSuite ( 'GroupTest' );
		
		
		
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
					$suite->addTestSuite ( trim($testName, '.php') );
				}
			}
		}
		return $suite;
	}
}

