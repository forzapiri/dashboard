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

class TaxRate extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('!select', 'country', 'Country', Address::getCountries()),
			DBColumn::make('!select', 'province', 'Province / State', Address::getStates()),
			DBColumn::make('!select', 'tax_class', 'Tax Class', TaxClass::getAllTaxClassesIdAndName()),
			DBColumn::make('!float', 'tax_rate', 'Tax Rate %'),
			DBColumn::make('timestamp', 'date_added', 'Date Added'),
			DBColumn::make('//text', 'last_modified', 'Last Modified'),
			DBColumn::make('tinymce', 'details', 'Details')
		);
		return new DBTable("ecomm_tax_rate", __CLASS__, $cols);
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

	public static function calculateTax($taxClass, $productPrice, $address){
		if (!$address)
			$address = DBRow::make('', 'Address');
		$country = $address->getCountry();
		$province = $address->getState();
		$sql = 'select `tax_rate` from ecomm_tax_rate where country = "' . e($country) . '" AND 
															province = "' . e($province) . '" AND
															tax_class = "' . e($taxClass) . '"';
		$result = Database::singleton()->query_fetch($sql);
		$taxRate = $result['tax_rate'];
		if (!$taxRate)
			$taxRate = 0;
		$taxRate = $taxRate / 100;
		return (float)$taxRate * (float)$productPrice;
	}
	
	public static function getAll($filter = true){
		$sql = 'select `id` from ecomm_tax_rate';
		if ($filter)
			$sql .= ' where status = 1';
		
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = DBRow::make($result['id'], 'TaxRate');
		}
		
		return $results;
	}
	static function getQuickFormPrefix() {return 'taxrate_';}
}
DBRow::init('TaxRate');
?>