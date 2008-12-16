<?php

require_once 'core/DBColumns.php';

require_once 'core/PEAR/PHPUnit/Framework/TestCase.php';

/**
 * DBColumnText test case.
 */
class DBColumnTextTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var DBColumnText
	 */
	private $DBColumnText;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->DBColumnText = new DBColumnText(/* parameters */);
	
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
		$this->DBColumnText->addElementTo(array('form' => &$form, 'id' => 'testfield'));
		$this->assertNotEquals(count($form->_elements), 0);
		$this->assertType('HTML_QuickForm_text', $form->_elements[0]);
	}

	/**
	 * Tests DBColumnText->type()
	 */
	public function testType() {
		$this->assertEquals($this->DBColumnText->type(), 'text');
	}
	
	public function testOptions() {
		$this->assertNull($this->DBColumnText->options());
	}

}
