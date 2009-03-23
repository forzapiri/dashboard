<?php
interface StorageInterface {
	public function type();
	public function render();
}

class Storage extends DBRow implements StorageInterface {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'type', 'Type'),
			DBColumn::make('text', 'original', 'Original File Location'),
			DBColumn::make('text', 'filename', 'Served File Name'),
			DBColumn::make('text', 'content_type', 'Content Type'),
			);
		return parent::createTable("storage", __CLASS__, $cols);
	}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function countAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}
	public function type() {
		return 'blob';
	}
	
	public function shouldCompress() {
		return false;
	}
	
	public function cachefile() {
		return SITE_ROOT . '/storage/cache/' . $this->type() . '/' . $this->get('filename') . '-' . $this->get('id') . '.gz';
	}
	
	public function isCached() {
		return file_exists($this->cachefile());
	}
	
	public function render() {
		ini_set("zlib.output_compression", "Off");
		
		if(!$this->shouldCompress() || (!isset($_SERVER['HTTP_ACCEPT_ENCODING']) or strrpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') === false)) {
			$compress_file = false;
		}else{
			$compress_file = true;
			$enc = in_array('x-gzip', explode(',', strtolower(str_replace(' ', '', $_SERVER['HTTP_ACCEPT_ENCODING'])))) ? "x-gzip" : "gzip";
		}
		
		if (file_exists(SITE_ROOT . '/' . $this->get('original'))) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: ' . $this->get('content_type'));
		    header('Content-Disposition: filename='.basename($this->get('filename')));
		    header('Content-Length: ' . filesize(SITE_ROOT . '/' . $this->get('original')));
		    
		    if ($compress_file) {
		    	header("Content-Encoding: " . $enc);
		    	
		    	if ($this->isCached()) {
		    		readfile($this->cachefile());
		    		exit;
		    	}
		    	
		    	$cacheData = gzencode(file_get_contents(SITE_ROOT . '/' . $this->get('original')), 9);
		    	echo $cacheData;
		    	$fp = fopen($this->cachefile(), "w");
				fwrite($fp, $cacheData);
				fclose($fp);
		    } else {
		    	ob_clean();
		   	 	flush();
			    readfile(SITE_ROOT . '/' . $this->get('original'));
		    }
		    exit;
		}
	}
}
DBRow::init('Storage');
