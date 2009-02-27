<?php

class Module_Block extends Module {
	
	public $icon = '/modules/Block/images/package_green.png';
	
	public function __construct() {
		$this->page = new Page();
		$this->page->with('Block')
			 ->show(array(
					'Title' => 'title',
					'Last Updated' => 'timestamp',
					'Status' => 'status'
			 ));
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
		include ('include/Block.php');
		$b = Block::getAllBlocks('active');
		
		$this->smarty->assign('blocks', $b);
		return $this->smarty->fetch('blocks.tpl');
	}

}
