<?php

require_once 'HTML/QuickForm/element.php';
require_once 'HTML/QuickForm/html.php';

class HTML_QuickForm_captcha extends HTML_QuickForm_static {

    function HTML_QuickForm_captcha($name = null, $label = null, $text = null) {
        $this->HTML_QuickForm_static($name, $label, $text);
        $this->_type = 'captcha';
    }
    
    function toHtml() {
    	$string = '<img src="/images/securimage_show.php?tid=' . date('U') . '" alt="' . $this->getLabel() . '" /><br />';
    	$string .= '<input type="text" name="' . $this->getName() . '" />';
    	return $string;
    }
}
