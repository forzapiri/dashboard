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

class HTML_QuickForm_dbimage extends HTML_QuickForm_element
{
	function HTML_QuickForm_dbimage($elementName = null, $src='',
	$attributes = null){
		$this->HTML_QuickForm_element($elementName, null, $attributes);
		$this->setSource($src);
		$this->setType('dbimage');
	}
	function setType($type){
		$this->_type = $type;
		//$this->updateAttributes(array('type'=>$type));
	} // end func setType
	function setSource($src){
		$this->updateAttributes(array('src' => '/images/image.php?id=' . $src));
	} // end func setSource
	function setBorder($border){
		$this->updateAttributes(array('border' => $border));
	} // end func setBorder
	function setAlign($align){
		$this->updateAttributes(array('align' => $align));
	} // end func setAlign
	function setHeight($height){
		$this->updateAttributes(array('height' => $height));
	}
	function setWidth($width){
		$this->updateAttributes(array('width' => $width));
	}
	function freeze(){
		return false;
	} //end func freeze
	function toHtml(){
		$this->setType(null);
		return '<img' . $this->getAttributes(true) . ' />';
	}
	function getFrozenHtml(){
		return $this->toHtml();
	}
	function setName($name){
		$this->updateAttributes(array('name' => $name));
	}
	function getName(){
		return $this->getAttribute('name');
	}


}
