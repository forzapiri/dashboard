<?php

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

?>