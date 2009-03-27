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
