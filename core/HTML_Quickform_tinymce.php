<?php

/**
 * Custom HTML_Quickform elementtype voor FCKeditor textarea
 *
 * This elementtype builds an FCKeditor instance for PEAR::HTML_Quickform
 * class. It extends HTML_Quickform
 *
 * 1. Place this file in the FCK directory (where fckeditor.php is)
 *
 * 2. Register the element type in Quickform.
 *    ! Make sure the path to this class file is relative to the location of the
 *      script that is calling this command.
 *        HTML_Quickform::registerElementType('fckeditor'
 *                                           ,'path/to/HTML_Quickform_fckeditor.php'
 *                                           ,'HTML_Quickform_fckeditor');
 *
 * 3. Create an instance in the Quickform object, here with some config options. See
 *    $_aFckConfigProps for all the possible options.
 *    ! The basepath (here in $sFCKBasePath) should be absolute to de documentroot
 *      of the webserver.
 *    ! It seems that StylesXmlPath needs the same absolute path as basepath.
 *
 *        $oQFElement = HTML_Quickform::createElement ('fckeditor'      // QF type
 *                                                    ,'myfckinstance'  // element name
 *                                                    ,'The Label');    // label
 *        $sFCKBasePath = '/path/from/documentroot/to/fckdir/';
 *        $oQFElement->setFCKProps($sFCKBasePath     // BasePath
 *                                ,'Basic'           // Toolbarset
 *                                ,'800'             // Width
 *                                ,'300'             // Height
 *                                ,array('SkinPath'                 => 'editor/skins/office2003/'
 *                                      ,'DefaultLanguage'          => 'nl'
 *                                      ,'StylesXmlPath'            => 'path/to/fckstyles.xml'
 *                                      ,'UseBROnCarriageReturn'    => 'true'
 *                                      ,'StartupFocus'             => 'false'
 *                                      ,'CustomConfigurationsPath' => 'config.js'
 *                                      ,'EditorAreaCSS'            => 'fck_editorarea.css'));
 *
 * @author Jordi Backx <jbackx@westsitemedia.nl>
 * @version 1.1
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
?>
