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
