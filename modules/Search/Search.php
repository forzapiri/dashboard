<?php
/**
 * Skeleton Module
 * @author Christopher Troup <chris@norex.ca>
 * @package Modules
 * @version 2.0
 */

/**
 * Training module.
 * 
 * This is essentially an example to learn how to write modules for the new CMS
 * system. It contains the bare minumum code to qualify for inclusion. This is a
 * good place to copy structure from when creating a new custom module.
 * @package Modules
 * @subpackage Skeleton
 */
class Module_Search extends Module {
	
	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getUserInterface($params) {
		$s = e($_REQUEST['search']);
		$sql = 'SELECT id, MATCH(content) AGAINST (\'' . $s . '\') as Relevance FROM content_page_data WHERE MATCH
				(content) AGAINST(\'' . $s . '\'  WITH QUERY EXPANSION) and status=1 ORDER
				BY Relevance DESC';
		$cr = Database::singleton()->query_fetch_all($sql);
		foreach ($cr as &$c) {
			$rel = $c['Relevance'];
			$c = ContentPageRevision::make($c['id']);
			$c->parent = ContentPage::make($c->get('parent'));
			$c->resulttype = 'Content';
			$c->relevance = $rel;
		}
		
		$this->smarty->assign('query', $s);
		$this->smarty->assign('results', $cr);
		return $this->smarty->fetch( 'results.tpl' );
	}

}

?>