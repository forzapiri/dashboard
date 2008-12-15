<?php

require_once 'core/DBTable.php';

require_once 'core/PEAR/PHPUnit/Framework/TestCase.php';

/**
 * DBTable test case.
 */
class DBTableTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var DBTable
	 */
	private $DBTable;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$sql = 'drop table if exists dbtabletest';
		Database::singleton()->query($sql);
		$sql = "CREATE TABLE `dbtabletest` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `testfield` varchar(32) NOT NULL default '',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
		Database::singleton()->query($sql);
		
		$sql = 'insert into dbtabletest set testfield="testtext"';
		Database::singleton()->query($sql);
		
		$this->cols = array(
			DBColumn::make('id?', 'id', 'ID'),
			DBColumn::make('!text', 'testfield', 'TestField'),
			);

		$this->DBTable = new DBTable("dbtabletest", 'DBTableTest', $this->cols);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$sql = 'drop table if exists dbtabletest';
		Database::singleton()->query($sql);
		$this->DBTable = null;
		parent::tearDown ();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		
	}

	/**
	 * Tests DBTable->column()
	 */
	public function testColumn() {
		foreach ($this->cols as $col) {
			$this->assertEquals($col, $this->DBTable->column($col->name()));
		}
	}

	/**
	 * Tests DBTable->columns()
	 */
	public function testColumns() {
		foreach ($this->cols as $col) {
			$this->assertArrayHasKey($col->name(), $this->DBTable->columns());
		}
	}
	
	/**
	 * Tests DBTable->deleteRow()
	 */
	public function testDeleteRow() {
		$this->assertNull($this->DBTable->deleteRow(1));
		$this->assertFalse($this->DBTable->fetchRow(1));
		$this->assertNull($this->DBTable->deleteRow(10000));
	}

	/**
	 * Tests DBTable->fetchRow()
	 */
	public function testFetchRow() {
		$this->assertNotNull($this->DBTable->fetchRow(1));
		$this->assertFalse($this->DBTable->fetchRow(10000));
	}

	/**
	 * Tests DBTable->getCache()
	 */
	public function testGetCache() {
		$row = $this->DBTable->fetchRow(1);
		$this->assertNull($this->DBTable->getCache(1));
		$this->assertNull($this->DBTable->setCache(1, $row));
		$this->assertNotNull($this->DBTable->getCache(1));
		$this->assertEquals($row, $this->DBTable->getCache(1));
	}

	/**
	 * Tests DBTable->loadColumnNames()
	 */
	public function testLoadColumnNames() {
		$this->assertNotNull($this->DBTable->loadColumnNames());
		$this->assertContains('id', $this->DBTable->loadColumnNames());
		$this->assertContains('testfield', $this->DBTable->loadColumnNames());
	
	}

	/**
	 * Tests DBTable->name()
	 */
	public function testName() {
		$this->assertEquals($this->DBTable->name(), 'dbtabletest');
	}

	/**
	 * Tests DBTable->setCache()
	 */
	public function testSetCache() {
		$row = $this->DBTable->fetchRow(1);
		$this->assertNull($this->DBTable->setCache(1, $row));
		$this->assertNotNull($this->DBTable->getCache(1));
		$this->assertEquals($row, $this->DBTable->getCache(1));;
	
	}

}

