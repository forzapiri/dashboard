<?php

require_once 'core/DBColumns.php';

require_once 'core/PEAR/PHPUnit/Framework/TestCase.php';

/**
 * DBColumnText test case.
 */
class DBColumnTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var DBColumnText
	 */
	private $DBColumnText;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->DBColumn = DBColumn::make('text','Test', 'TEST');
	
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->DBColumnText = null;
		parent::tearDown ();
	}

	/**
	 * Tests DBColumnText->addElementTo()
	 */
	public function testAddElementTo() {
		$form = new Form();
		$this->assertEquals(count($form->_elements), 0);
		$this->DBColumn->addElementTo(array('form' => &$form, 'id' => 'testfield'));
		$this->assertNotEquals(count($form->_elements), 0);
		$this->assertType('HTML_QuickForm_text', $form->_elements[0]);
	}

	/**
	 * Tests DBColumnText->type()
	 */
	public function testType() {
		$this->assertEquals($this->DBColumn->type(), 'text');
	}
	
	public function testOptions() {
		$this->assertEquals(count($this->DBColumn->options()), 1);
	}
	
	public function testName() {
		$this->assertEquals('Test', $this->DBColumn->name());
	}
	
	public function testHidden() {
		$this->assertFalse($this->DBColumn->hidden());
	}
	
	public function testRequired() {
		$this->assertFalse($this->DBColumn->required());
	}
	
	public function testNoForm() {
		$this->assertFalse($this->DBColumn->noForm());
	}
	
	public function testDisplay() {
		$this->assertNull($this->DBColumn->display(null));
	}
	
	public function testToDB() {
		$this->assertNull($this->DBColumn->toDB(null));
	}

	public function testToForm() {
		$this->assertNull($this->DBColumn->toForm(null));
	}
	
	public function testFromForm() {
		$this->assertNull($this->DBColumn->fromForm(null));
	}
	
	public function testSuggestedMySQL() {
		$this->assertEquals('text', $this->DBColumn->suggestedMysql());
	}
	
	public function testGetType() {
		$this->assertGreaterThan(0, count(DBColumn::getTypes()));
	}
}
