<?php

require_once('Database.php');
class Image {
	
	public $id;
	public $content_type;
	public $filename;
	public $filesize;
	public $data;
	// $im is set by lazy evaluation (i.e., on first access attempt)
	// public $im;  
	public $hash;
	public $cached = false;
	public $params = array();
	public $renType;

	public function __get($name) {
		switch ($name) {
			case "im":
				 if ($this->id != null) {
				 	if ($this->cached) {
						$sql = 'select data from images_cache where hash="' . $this->cachedHash . '"';
				 	} else {
				 		$sql = "select data from images where id=$this->id";
				 	}
				 	$result = Database::singleton()->query_fetch($sql);
				 	$this->im = @imagecreatefromstring($result['data']);
				 	return $this->im;
				 }
		}
	}
	
	public function __construct($params = null) {
		if (@$params['id'] == '') {
			//$this->im = imagecreatetruecolor(2, 1);
		} else {
			if (!is_null($params['id'])) {
				$this->id = $params['id'];
				// check for cached image with those params
				if (!is_null($params) && @$this->isCached($params)) {
					return;
				}
				
				$sql = 'select id, content_type, filename, filesize from images where id=' . $params['id'] . ' limit 1';
				$image = @Database::singleton()->query_fetch($sql);
				$this->content_type = $image['content_type'];
				$this->filename = $image['filename'];
				$this->filesize = $image['filesize'];
				@$this->hash = $image['hash'];
				if(@!empty($params['type'])){
					$this->renType = $params['type'];
				} else {
					$this->renType = 'jpg';
				}
				
				if (!is_null($params)) {
					$this->params = $params;
					if (isset($params['w'])) $this->width($params['w']);
					if (isset($params['h'])) $this->height($params['h']);
					if (isset($params['cliph'])) $this->cliph($params['cliph']);
					if (isset($params['clipw'])) $this->clipw($params['clipw']);
					if (isset($params['border'])) $this->border($params['border']);
				}
			}
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function isCached($params) {
		$hashbuilder = '';
		foreach (@$params as $key => $param) {
			$hashbuilder .= $param;
		}
		$this->hash = sha1($hashbuilder);
		$this->cachedHash = $this->hash;
		$sql = 'select hash from images_cache where hash="' . $this->hash . '"';
		
		$result = Database::singleton()->query_fetch($sql);
		if (!is_null($result)) {
			// $this->im = imagecreatefromstring($result['data']);
			$this->cached = true;
		}
	}
	
	public function insert($data) {
		$fp = fopen($data['tmp_name'], 'r');
		$content = fread($fp, filesize($data['tmp_name']));
		$content = addslashes($content);
		fclose($fp);
		
		$sql = 'insert into images set data="' . $content . '", content_type="' . $data['type'] . '", filename="' . $data['name'] . '", filesize="' . filesize($data['tmp_name']) . '"';
		Database::singleton()->query($sql);
		
		$this->id = Database::singleton()->lastInsertedID();
		return $this->id;
	}
	
	public function width($width) {
		$ratio = imagesy($this->im) / imagesx($this->im);
		$im = imagecreatetruecolor($width, $width * $ratio);
		imagesavealpha($im, true);
		$alpha = imagecolorallocatealpha($im, 255, 255, 255, 0);
		imagefilledrectangle($im, 0, 0, imagesx($im), imagesy($im), $alpha);
		
		imagecopyresampled($im, $this->im, 0, 0, 0, 0, $width, $width * $ratio, imagesx($this->im), imagesy($this->im));
		$this->im = $im;
	}
	
	public function height($height) {
		
		$ratio = imagesx($this->im) / imagesy($this->im);
		$im = imagecreatetruecolor($height * $ratio, $height);

		imagecopyresampled($im, $this->im, 0, 0, 0, 0, $height * $ratio, $height, imagesx($this->im), imagesy($this->im));
		$this->im = $im;
	}
	
	public function cliph($height) {
		$width = imagesx($this->im);
		$curheight = imagesy($this->im);

		//if ($width > $curheight) {
			$this->height($height);
			//$this->width($height);
		//}
		
		$im = imagecreatetruecolor($height, $height);
		imagesavealpha($im, true);
		$alpha = imagecolorallocatealpha($im, 255, 255, 255, 0);
		imagefilledrectangle($im, 0, 0, imagesx($im), imagesy($im), $alpha);
		
		imagecopy($im, $this->im, 0, 0, 0, 0, imagesx($this->im), $height);
		
		$this->im = $im;
	}
	
	public function clipw($width) {
		$curwidth = imagesx($this->im);
		$height = imagesy($this->im);
		
		//if ($height > $curwidth) {
			$this->width($width);
			//$this->height($width);
		//}
		$im = imagecreatetruecolor($width, $width);
		
		imagesavealpha($im, true);
		$alpha = imagecolorallocatealpha($im, 255, 255, 255, 0);
		imagefilledrectangle($im, 0, 0, imagesx($im), imagesy($im), $alpha);
		
		imagecopy($im, $this->im, 0, ($width - imagesy($this->im)) / 2, 0, 0, $width, imagesy($this->im));
		$this->im = $im;
	}
	
	public function border($color) {
		$im =& $this->im;
		$color = hexdec($color);
		$border_color = imagecolorallocate($im, (0xFF & ($color >> 0x10)), (0xFF & ($color >> 0x8)), (0xFF & $color));
		imagerectangle($im,0,0,imagesx($im)-1,imagesy($im)-1,$border_color);
		imagerectangle($im,1,1,imagesx($im)-2,imagesy($im)-2,$border_color);
	}
	
	public function render() {
		if ($this->cached == false) {
			$sql = 'insert into images_cache set image_id=' . @$this->params['id'];

			$hashbuilder = '';
			foreach ($this->params as $key => $param) {
				$hashbuilder .= $param;
			}
			$this->hash = sha1($hashbuilder);
			$sql .= ', hash="' . $this->hash . '"';
			
			ob_start();
			switch($this->content_type) {
				case "image/png":
					imagepng($this->im); 
					break;
				case "image/gif":
					imagegif($this->im);
					break;
				case "image/jpeg":
					imagejpeg($this->im);					
					break;
				case "image/wbmp":
					imagewbmp($this->im);
					break;
			}
			$content = ob_get_clean();
			
			$sql .= ', data="' . addslashes($content) . '"';
			Database::singleton()->query($sql);

		}
		header ("Expires: Sat, 29 Apr 2034 05:00:00 GMT");
		header('Content-Disposition: inline; filename="' . $this->filename . '"');
		if (function_exists("imagepng") && $this->renType == 'png') { 
	   	 	header("Content-type: image/png");
	   	 	imagesavealpha($this->im, true);
	    	imagepng($this->im); 
		} elseif (function_exists("imagegif") && $this->renType == 'gif') {
	    	header("Content-type: image/gif");
	    	imagegif($this->im);
		} elseif (function_exists("imagejpeg") && ($this->renType == 'jpeg' || $this->renType == 'jpg')) {
	    	header("Content-type: image/jpeg");
	    	imagejpeg($this->im, null, 75);
		} else {
		    die("No image support in this PHP server");
		} 
		
	}
	
}

?>