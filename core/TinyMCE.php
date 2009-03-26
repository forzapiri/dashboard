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

class TinyMCE {
	
	public $basepath = '/core/tinymce/jscripts';
	public $name;
	public $value = '<p></p>';
	public $mode = 'exact';
	public $theme = 'advanced';
	public $stylesheet = '/css/style.css';
	public $bodyId = 'mainContent';
	public $bodyClass = 'tinymce';
	
	public function __construct( $name = 'editor' ) {
		
		$this->name = $name;
		
	}
	
	public function toHTML() {
		return '
		<textarea id="' . $this->name . '" name="' . $this->name . '" rows="15" cols="16" class="' . $this->name . '" style="width: 200px">' . $this->value . '</textarea>
			<script type="text/javascript">
			initRTE("' . $this->mode . '","' . $this->theme . '","' . $this->name . '","' . $this->stylesheet . '","' . $this->bodyId . '","' . $this->bodyClass . '");
			</script>';
			
	}
	
}
