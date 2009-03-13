<?php
/**
 * Analytics Module
 * @author Adam Thurlow <adam@norex.ca>
 * @package Modules
 */

/**
 * !!!!!!!!READ ME!!!!!!!!!
 * Analytics
 * 
 * This is an interface for adding Google Analytics JS to each page.
 * Schema is provided, includes table drops.
 * Schema also includes line to add to the Admin Menu
 * 
 * Usage: in site.tpl, add line {module class="Analytics"} in the head.
 * 
 * @package Modules
 * @subpackage Skeleton
 */

class Module_Analytics extends Module {
	
	public function __construct() {
		$this->page = new Page();
		$this->page->with('Analytics')
			 ->show(array(
					'Code' => 'content',
					'Last Updated' => 'timestamp',
			 ))
			 ->name('Analytics Script')
			 ->showCreate(false);
			 
		$this->page->with('Analytics'); 
	}

	function getAdminInterface() {
		return $this->page->render();
	}
	
	function getUserInterface($params) {
		include_once ('include/Analytics.php');
		$s = Analytics::getAllAnalyticss('active');
		
		$this->smarty->assign('scripts', $s);
		return $this->smarty->fetch('analy.tpl');
	}
	
	function topLevelAdmin() {
		$s = Analytics::getAllAnalyticss();
		$this->smarty->assign('scripts', $s);
		
		return $this->smarty->fetch( 'admin/adminanaly.tpl' );
	}

}
