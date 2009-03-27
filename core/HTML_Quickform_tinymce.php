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

class HTML_Quickform_tinymce extends HTML_Quickform_element {

	/**
	 * Path to FCK class
	 *
	 * @var string Path to PHP FCK class
	 * @access private
	 */
	public $_sFckBasePath = '/core/fckeditor/';

	/**
	 * Toolbar
	 *
	 * @var string Requested toolbarset
	 * @access private
	 */
	public $_sToolbarSet = NULL;

	/**
	 * Height of editor
	 *
	 * @var string Height
	 * @access private
	 */
	public $_sHeight = '500';

	/**
	 * Width of editor
	 *
	 * @var string Width
	 * @access private
	 */
	public $_sWidth = NULL;

	/**
	 * FCK properties
	 *
	 * @var array Set of FCK only properties
	 * @access private
	 */
	public $_aFckConfigProps = array ('CustomConfigurationsPath' => NULL, 'EditorAreaCSS' => NULL, 'Debug' => NULL, 'SkinPath' => NULL, 'PluginsPath' => NULL, 'AutoDetectLanguage' => NULL, 'DefaultLanguage' => NULL, 'EnableXHTML' => NULL, 'EnableSourceXHTML' => NULL, 'GeckoUseSPAN' => NULL,
			'StartupFocus' => NULL, 'ForcePasteAsPlainText' => NULL, 'ForceSimpleAmpersand' => NULL, 'TabSpaces' => NULL, 'UseBROnCarriageReturn' => NULL, 'LinkShowTargets' => NULL, 'LinkTargets' => NULL, 'LinkDefaultTarget' => NULL, 'ToolbarStartExpanded' => NULL, 'ToolbarCanCollapse' => NULL, 
			'StylesXmlPath' => NULL );

	/**
	 * Class constructor
	 *
	 * @param string $sElementName  Name attribute of element
	 * @param mixed  $mElementLabel Label attribute of element
	 * @param mixed  $mAttributes   Other non-FCK optional attributes
	 *
	 * @access public
	 * @return void
	 */
	function HTML_Quickform_tinymce($sElementName = NULL, $mElementLabel = NULL, $mAttributes = NULL) {
		HTML_Quickform_element::HTML_Quickform_element ( $sElementName, $mElementLabel, $mAttributes );
		$this->_persistantFreeze = TRUE;
		$this->_type = 'tinymce';
	} // End constructor

	/**
	 * Register name atribute
	 *
	 * @param string $sName Name attribute of element
	 * @access public
	 * @return void
	 */
	function setName($sName) {
		$this->updateAttributes ( array ('name' => $sName ) );
	} // End function setName


	/**
	 * Naam teruggeven (name attribute)
	 *
	 * @access public
	 * @return string Name attribute element
	 */
	function getName() {
		return $this->getAttribute ( 'name' );
	} // End function getName


	/**
	 * Waarde/inhoud registreren (value attribute)
	 *
	 * @param string $sWaarde Value attribute of element
	 * @access public
	 * @return void
	 */
	function setValue($sValue) {
		$this->updateAttributes ( array ('value' => $sValue ) );
	} // End function setValue


	/**
	 * Return Value (value attribute)
	 *
	 * @access public
	 * @return string Value attribute element
	 */
	function getValue() {
		return $this->getAttribute ( 'value' );
	} // End function getValue


	/**
	 * Generate and return HTML code for editor
	 *
	 * @access public
	 * @return string HTML code element
	 */
	function toHtml() {
		require_once('TinyMCE.php');
			
		$editor = new TinyMCE($this->getName());
		$editor->value = $this->getValue();
			
		return $editor->toHTML();
	} // End function toHtml

}
