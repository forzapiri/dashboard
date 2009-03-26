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

require_once ('HTML/QuickForm.php');
require_once ('HTML/QuickForm/element.php');
require_once (dirname(__FILE__) . '/PEAR/HTML/QuickForm/advmultiselect.php');
require_once ('HTML/QuickForm/Renderer/ArraySmarty.php');
require_once 'HTML/QuickForm/Renderer/Tableless.php';

// Register the fckeditor form element type with the QuickForm object.
HTML_Quickform::registerElementType('fckeditor', 'HTML_Quickform_fckeditor.php', 'HTML_Quickform_fckeditor');
HTML_Quickform::registerElementType('tinymce', 'HTML_Quickform_tinymce.php', 'HTML_Quickform_tinymce');
HTML_Quickform::registerElementType('swfchart', 'HTML_Quickform_swfchart.php', 'HTML_Quickform_swfchart');
HTML_Quickform::registerElementType('dbimage', 'HTML_Quickform_dbimage.php', 'HTML_Quickform_dbimage');
HTML_Quickform::registerElementType('captcha', 'HTML_Quickform_captcha.php', 'HTML_Quickform_captcha');

/**
 * Create object oriented Forms
 * 
 * This is just a wrapper for the PEAR Quickform package. It simplifies syntax as well as registers custom form element
 * types, such as FCKeditor.
 *
 * @package CMS
 * @subpackage Core
 */
class Form extends HTML_QuickForm {

	private $processed = false;
	function setProcessed() {$this->processed = true;}
	function isProcessed() {return $this->processed;}

	private $resubmit = false;
	function setResubmit() {$this->resubmit = true;}
	function isResubmit() {return $this->resubmit;}
	
	public function display() {
		$renderer =& new HTML_QuickForm_Renderer_Tableless();
		$this->accept($renderer);
		$this->removeAttribute('name');
		
		return $renderer->toHtml();
	}
	
	public static function statusArray() {
		return array(1 => 'Active', 0 => 'Inactive');
	}
	
	public static function booleanArray() {
		return array(1 => 'Yes', 0 => 'No');
	}
	
	public static function getStatesArray() {
		$sql = 'select id, name from states';
		$r = Database::singleton()->query_fetch_all($sql);
		
		$array = array();
		foreach ($r as &$state) {
			$array[$state['id']] = $state['name'];
		}
		return $array;
	}
	
}
