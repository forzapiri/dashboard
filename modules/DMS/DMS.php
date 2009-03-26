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

class Module_DMS extends Module {
	
	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getAdminInterface() {
		
		if (isset($_REQUEST['X-CreateClass'])) {
			$item = DBRow::make(null, $_REQUEST['X-CreateClass']);
			$form = $item->getAddEditForm('/admin/DMS');
			$form->addElement('hidden', 'X-CreateClass', $_REQUEST['X-CreateClass']);
			
			if ($form->isProcessed()) {
				$all = array();
				foreach (call_user_func(array($_REQUEST['X-CreateClass'], 'toArray')) as $key => $val) {
					$all[] = array('key' => $key, 'value' => $val);
				}
				$array = array(
					'created' => $item->get('id'),
					'all' => $all 
				);
				echo json_encode($array);
				die();
			}
			
			return $form->display();
		}
		$page = new Page();
		$page->with('File')
			->show(array(
				'Filename' => 'filename',
				'Description' => 'description'
			));
			
		return $page->render();
	}

}
