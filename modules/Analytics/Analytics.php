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
			 		'Status' => 'status'
			 ))
			 ->Pre('<div>
			 <p>To view Analytics for your site, visit <a href="http://google.com/analytics" target="new">The Google Analytics </a> page. </p>
			 <h4>Initial Setup:</h4>
			 <ul>
			 	<li> Sign Up for a Google Account, if you don`t have one already | <a href="http://google.com/" target="new">here.</a>
			 	<li> Step 1 - General Information | <a href="http://img.skitch.com/20090323-kkpygktagf5jauuk2sx187yke3.jpg" rel="facebox">pic</a> </li>
			 	<li> Step 3 - Agree to the Terms of Service </li>
			 	<li> Step 4 - Copy the google tracking code  | <a href="http://img.skitch.com/20090323-eexf4ypd139tu5p41eyki6h79m.png" rel="facebox">pic</a></li>
			 	<li> Step 5 - Create the object in the CMS | <a href="http://img.skitch.com/20090323-r6pie5bmx59bjy4g6pn7k1j9r5.png" rel="facebox">pic</a></li>
			 	<li> Step 6 - Paste the code and save | <a href=http://img.skitch.com/20090323-r3375fj2iruh1ineja468rp9yj.png" rel="facebox">pic</a></li>
			 	<li> Step 7 - Profit. </li>
			 </ul>
			 </div>')
			 ->Post('<p>At any time, you can edit the code and it will update site-wide.</p>')
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
