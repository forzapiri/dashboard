<?php

require_once 'HTML/QuickForm/element.php';
require_once 'HTML/QuickForm/html.php';

class HTML_QuickForm_swfchart extends HTML_QuickForm_html {

    function HTML_QuickForm_swfchart($text = null) {
        $this->HTML_QuickForm_static(null, null, $text);
        $this->_type = 'swfchart';
    }

    function toHtml() {
    	$string = $this->_getTabs() . "<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' width='700' height='320' id='charts' ALIGN=''>
			<PARAM NAME='movie' VALUE='/core/charts/charts.swf?library_path=%2Fcore%2Fcharts%2Fcharts_library&stage_width=400&stage_height=250&php_source=" . urlencode($this->_text) . "'> 
			<PARAM NAME='quality' VALUE='high'> 
			<PARAM NAME='bgcolor' VALUE='#666666'> 
			
			<EMBED src='/core/charts/charts.swf?library_path=%2Fcore%2Fcharts%2Fcharts_library&stage_width=400&stage_height=250&php_source=" . urlencode($this->_text) . "' quality='high' bgcolor='#ffbf9c' width='700' height='320' NAME='charts' ALIGN='' swLiveConnect='true' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'>
			</EMBED>
			
			</OBJECT>";
    	
    	return $string;
    }
    

}
?>
