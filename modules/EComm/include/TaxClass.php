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

include_once(SITE_ROOT.'/core/DBColumn.php');
include_once(SITE_ROOT.'/core/DBColumns.php');

class TaxClass extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!text', 'name', 'Name'),
			DBColumn::make('timestamp', 'date_added', 'Date Added'),
			DBColumn::make('//text', 'last_modified', 'Last Modified'),
			DBColumn::make('select', 'status', 'Status',array('1'=>'Active','0'=>'Inactive')),
			DBColumn::make('tinymce', 'details', 'Details')
		);
		return new DBTable("ecomm_tax_class", __CLASS__, $cols);
	}
	
	public function getAddEditFormSaveHook($form){
		$this->setLastModified(date('Y-m-d G:i:s'));
	}
	
	public function getAddEditFormHook($form){
		if ($this->getDateAdded())
			$form->addElement('static', $this->quickformPrefix() . 'date_added_label', 'Date Added', $this->getDateAdded()->getDate());
		if ($this->getLastModified())
			$form->addElement('static', $this->quickformPrefix() . 'last_modified_label', 'Last Modified', $this->getLastModified());
		$form->addElement('button', 'btn_cancel','Cancel',array("onclick"=>"document.location='/admin/EComm&section=" . $_REQUEST["section"] . "';"));
	}
	
	public static function getAll($filter = true){
		$sql = 'select `id` from ecomm_tax_class';
		if ($filter)
			$sql .= ' where status = 1';
		
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'TaxClass');
		}
		
		return $results;
	}
	
	public static function getAllTaxClassesIdAndName(){
		$results = array();
		
		$sql = 'select `id`,`name` from ecomm_category';
		$allTaxClasses = TaxClass::getAll(false);
		foreach ($allTaxClasses as $taxClass) {
			$results[$taxClass->getId()] = $taxClass->getName();
		}
		return $results;
	}
	
	static function getQuickFormPrefix() {return 'taxclass_';}
}
DBRow::init('TaxClass');
?>