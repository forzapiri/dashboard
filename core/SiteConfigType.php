<?php
abstract class SiteConfigType {
	/* These are the functions you may want to redefine in a subclass. */
	abstract function _getName();                     // Return name of type as it appears in the db.
	function _getValue($val) {return (string) $val;}  // Return a convenient php value, reflecting the type.
	function _setValue($config, $value) {$config->setValue($value);}
	function _getDisplayString($val) {return (string) $val;} // Return the string which will be displayed in the admin page

	function _setFormField ($form, $config) {         // Set the form field siteconfig_value and add any required rules. 
		$form->addElement('text', 'siteconfig_value', NOREX ? 'Value' : '');
	}

	/* Implementation follows */	
	static private $types = array();
	static function getTypeList () {
		global $types;
		foreach ($types as $type) {
			$t[] = $type->_getName();
		}
		return implode(", ", $t);
	}
	static function getValue($siteConfig) {
		return SiteConfigType::getType($siteConfig)->_getValue($siteConfig->getRawValue());
	}
	static function setValue($siteConfig, $value) {
		return SiteConfigType::getType($siteConfig)->_setValue($siteConfig, $value);
	}
	static function getDisplayString($siteConfig) {
		return SiteConfigType::getType($siteConfig)->_getDisplayString($siteConfig->getRawValue());
	}
	static function setFormField ($form, $siteConfig) {
		return SiteConfigType::getType($siteConfig)->_setFormField($form, $siteConfig);
	}
	static function get($typeName) {
		global $types;
		if (!isset($types[$typeName])) {error_log ('Type not found: ' . $typeName);}
		return $types[$typeName];
	}
	static function getType($siteConfig) {
		global $types;
		$result = SiteConfigType::get($siteConfig->getTypeName());
		return $result;
	}
	static function register($type) {
		global $types;
		$types[$type->_getName()] = $type;
	}
}

/*  ----------------------------------------------------------- */
class SiteConfigStringType extends SiteConfigType {
	function _getName() {return 'string';}
}
SiteConfigType::register (new SiteConfigStringType());
/*  ----------------------------------------------------------- */
class SiteConfigEmailType extends SiteConfigType {
	function _getName() {return 'email';}
	function _setFormField ($form, $config) {
		parent::_setFormField($form, $config);
		$form->addRule('siteconfig_value', 'Email address required', 'required', '', 'client');
		$form->addRule('siteconfig_value', 'Enter a valid email', 'email', '', 'client');
	}
}
SiteConfigType::register (new SiteConfigEmailType());
/*  ----------------------------------------------------------- */
class SiteConfigIntType extends SiteConfigType {
	function _getName() {return 'int';}
	function _getValue($val) {return (integer) $val;}
	function _setFormField ($form, $config) {
		parent::_setFormField($form, $config);
		$form->addRule('siteconfig_value', 'Number required', 'numeric', '', 'client');
	}
}
SiteConfigType::register (new SiteConfigIntType());
/*  ----------------------------------------------------------- */
class SiteConfigEnumType extends SiteConfigType {
	function _getName() {return 'enum';}
	function _setFormField ($form, $config) {
		$options = $config->getRawType();
		preg_match('/^[a-z]+\((.*)\)$/', $config->getRawType(), $matches);
		$options = split (',', $matches[1]);
		$options = array_combine ($options, $options);
		$form->addElement('select', 'siteconfig_value', NOREX ? 'Value' : '', $options);
	}
}
SiteConfigType::register(new SiteConfigEnumType());
/*  ----------------------------------------------------------- */
class SiteConfigLongstringType extends SiteConfigType {
	function _getName() {return 'longstring';}
	function _setFormField ($form, $config) {
		$form->addElement('textarea', 'siteconfig_value', NOREX ? 'Value' : '');
	}
}
SiteConfigType::register(new SiteConfigLongstringType());
/*  ----------------------------------------------------------- */
class SiteConfigListType extends SiteConfigType {
	function _getName() {return 'list';}
	function _getValue($val) {
		return $val == '' ? array() : array_map('trim', explode(",", $val)); 
	}
	function _setValue($config, $value) {
		$config->setValue(implode (", ", array_map ('trim', $value)));
	}
	function _getDisplayString($val) {return implode ($this->_getValue($val), ", ");}
}
SiteConfigType::register(new SiteConfigListType());
/*  ----------------------------------------------------------- */
class SiteConfigPhpType extends SiteConfigType {
	function _getName() {return 'php';}
	function _getValue($val) {return unserialize($val);}
	function _setValue($config, $value) {$config->setValue(serialize($value));}
}
SiteConfigType::register(new SiteConfigPhpType());
?>
