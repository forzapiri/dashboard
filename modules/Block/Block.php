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

class Module_Block extends Module {
	
	public $icon = '/modules/Block/images/package_green.png';
	
	public function __construct() {
		$this->page = new Page();
		$this->page->with('Block')
			 ->show(array(
			 		'Sort Order' => 'sort',
					'Title' => 'title',
					'Last Updated' => 'timestamp',
					'Status' => 'status',
			 ))->filter('order by sort');
	}
	
	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getAdminInterface() {
		return $this->page->render();
	}
	
	function getUserInterface($params) {
		include_once ('include/Block.php');
		$b = Block::getAllBlocks('active');
		
		$this->smarty->assign('blocks', $b);
		return $this->smarty->fetch('blocks.tpl');
	}

}
