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
			$item = DBRow::make($_REQUEST['X-CreateClass'], null);
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
				return json_encode($array);
			}
			
			return $form->display();
		}
		
		$page = new Page();
		$page->with('File')
			->show(array(
				'Filename' => 'filename'
			));
			
		return $page->render();
	}

}

?>