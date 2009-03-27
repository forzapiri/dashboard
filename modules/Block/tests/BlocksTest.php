<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

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

