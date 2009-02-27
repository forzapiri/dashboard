<?php

class Ticket {
	public $errno, $errstr, $errfile, $errline;
	
	public function submit() {
		$string = '<?xml version="1.0" encoding="UTF-8"?>';
		$string .= '<ticket>
		<title>' . $this->errstr . '</title>
		<body>' . $this->errstr . "\n\nFrom: " . $this->errfile . "\n\nOn Line: " . $this->errline . '</body>
		<state>error</state>
		<tag>' . $_SERVER['SERVER_NAME'] . '</tag>
		</ticket>';
		
		$fp = fsockopen("norex.lighthouseapp.com", 80, $errno, $errstr, 30);
		if (!$fp) {
		    //echo "$errstr ($errno)<br />\n";
		} else {
		    $out = "POST /projects/21176/tickets.xml HTTP/1.1\r\n";
		    $out .= "Host: norex.lighthouseapp.com\r\n";
		    $out .= "Content-type: application/xml\r\n";
			$out .= "Content-length: " . strlen($string) . "\r\n";
			$out .= "X-LighthouseToken: aecac0cc29471535cd2004621d0ce5efdb772ca3\r\n";
			$out .= "Connection: close\r\n\r\n";
			$out .= $string;
		    fwrite($fp, $out);
		    fclose($fp);
		}
	}
}
