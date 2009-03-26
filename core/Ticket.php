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
