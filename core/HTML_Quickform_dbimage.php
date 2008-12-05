<?php
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
?>