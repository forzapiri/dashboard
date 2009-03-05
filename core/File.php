<?php
define ('DATA_STORAGE_DIR', 'files/');
class File extends DBRow {
	function createTable() {
		$cols = array(
			DBColumn::make('id?'),
			DBColumn::make('//string','type', 'Type'),
			DBColumn::make('//string','filename', 'Filename'),
			DBColumn::make('text','description', 'Description'),
			DBColumn::make('//enum(public,private)','permission', 'Permission')
			);
		return parent::createTable ('files', __CLASS__, $cols);
	}

	static function make($id = null) {return parent::make($id, __CLASS__);}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}

	function getLink() {return "/" . DATA_STORAGE_DIR . $this->getPath() . $this->getLocalFilename();}
	function getImgTag($arg = array(), $alt = null) {
		$link = $this->getImageLink($arg);
		if (!$alt) $alt = htmlspecialchars($this->getDescription(), ENT_QUOTES);
		if (!$alt) $alt = htmlspecialchars($this->getFilename());
		$string = "<img src='$link' alt='$alt' />";
		return $string;
	}
	function getImageLink($args = array()) {
		// $arg is either array(width => 100, height => 200, ...) OR
		// "width=100&height=100&..."
		//
		// Parameters need to be passed in through the URL's query string:
		// image		absolute path of local image starting with "/" (e.g. /images/toast.jpg)
		// w or width	maximum width of final image in pixels (e.g. 700)
		// h or height	maximum height of final image in pixels (e.g. 700)
		// color		(optional) background hex color for filling transparent PNGs (e.g. 900 or 16a942)
		// cropratio	(optional) ratio of width to height to crop final image (e.g. 1:1 or 3:2)
		// nocache		(optional) does not read image from the cache
		// quality		(optional, 0-100, default: 90) quality of output image
		$path = $this->getLink();
		$image_args = array ("w", "width", "h", "height", "color", "cropratio", "quality");
		$image_flags = array ("nocache");
		if (is_string ($args)) {
			$items = split('&', $args);
			$args = array();
			foreach ($items as $item) {
				$tmp = split('=', $item);
				switch (count($tmp)) {
				case 1: $args[] = $tmp[0]; break;
				case 2: $args[$tmp[0]] = $tmp[1]; break;
				default: error_log ("Too many equal signs");
				}
			}
		}
		
		$results = array();
		
		foreach ($args as $key => $value) {
			if (is_numeric ($key) && in_array ($value, $image_flags)) {
				$results[] = "$key";
			} elseif (in_array ($key, $image_args)) {
				$results[] = "$key=$value";
			} else {
				error_log ("Key $key=$value not recognized in getLink");
			}
		}
		$args = implode ("&", $results);
		if ($args) $args = "?$args";
		return "/im$path$args";
	}
	
	function getSize() {return filesize($this->getDirectoryFile());}

	/* Perhaps some of these should be private */
	private function getDirectoryFile() {return $this->getDirectory() . $this->getFilename();}
	private function getDirectory() {return SITE_ROOT . "/" . DATA_STORAGE_DIR . $this->getPath();}
	private function getPath() {
		$id = (string) $this->getId();
		if (1&strlen($id)) $id = "0$id";
		$path = implode('/', str_split($id,2));
		return "$path/";
	}
	private function getLocalFilename() {
		// Replaces the extension with one matching the mime type, if available
		$filename = $this->getFilename();
		$filename = preg_replace('/ /', '_', $filename);
		$filename = preg_replace('/[^0-9a-zA-Z._]/', '', $filename);
		if (!$filename) return "file.tmp";
		$pos = strrpos ($filename, '.');
		if ($pos === false) return "$filename.tmp";
		$type = $this->getType();
		$ext = @$extensions[$type];
		if (!$ext) $ext = substr ($filename, 1+$pos);
		if (!$ext) $ext = "tmp";
		return substr($filename, 0, $pos) . ".$ext";
	}

	function getFullPath(){return $this->getDirectory() . $this->getLocalFilename();}
	
	private function _insert($tempurl, $type, $filename, $copy = true) {
		if (!is_readable ($tempurl)) {
			error_log ("Upload of file ".$tmpurl." failed.");
			return false;
		}
		// Assume the file is uploaded (for now) and set up the file object; need to save() to get a new id.
		$this->setType ($type);
		$this->setFilename ($filename);
		if (!$this->getId()) $this->save();
		if (!$this->getId()) {
			error_log ("Save failed in File.php");
			return false;
		}
		$dir = $this->getDirectory();
		$file = $this->getLocalFilename();
		
		$oldmask = umask();
		umask(0);
		mkdir($dir,0777,true);
		umask($oldmask);

		$method = $copy ? 'copy' : 'move_uploaded_file';
		$Method = $copy ? 'Copy' : 'Move';
		if (!$method ($tempurl, $dir.$file)) {
			error_log ("$Method of file $tempurl to $dir$file failed.");
			return false;
		}
	}
	
	function insert($data, $type = null, $filename = null) {
		// $data is either an array OR a quickform result OR a URL to be copied;
		// if the latter, proved $type and $filename
		if ($data instanceof HTML_QuickForm_file) {$data = $data->getValue();}
		if (is_array ($data)) return $this->_insert($data['tmp_name'], $data['type'], $data['name'], false);
		else                  return $this->_insert($data, $type, $filename, true);
	}

	function getAddEditFormHook($form) {
		$form->addElement ('file', 'upload_file', 'Upload file');
	}

	function setPublic() {$this->setPermission('public');}
	function setPrivate() {$this->setPermission('private');}
	function &save(&$notification = null) {
		parent::save($notification);
		if (!$this->getId()) return; // Just a security precaution; this case should not happen.
		$file = $this->getDirectory() . 'public';
		if ($this->getPermission() == 'public') touch($file);
		else @unlink($file);
		return $this;
	}
	function getAddEditFormBeforeSaveHook($form) {
		$el = $form->getElement('upload_file');
		if ($el->isUploadedFile()) {
			$this->insert($_FILES['upload_file']);
		}
	}
	
	private $extensions = array (
		// These are overrides for extensions as a function of mime type.
		'/image/png' => 'png',
		'/image/gif' => 'gif',
		'/image/jpeg' => 'jpg',
		'/image/wbmp' => 'wbmp',
		'/text/css' => 'css',
		);
		
	public function toArray($where = null) {
		$array = array();
		foreach (self::getAll($where) as $s) {
			$array[$s->get('id')] = $s->get('filename');
		}
		return $array;
	}
}
DBRow::init('File');
