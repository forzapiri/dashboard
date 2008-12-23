<?php
define (DATA_STORAGE_DIR, '/files/');
class File extends DBRow {
	// IMAGES: id, data, content_type, filename, filesize
	// DATASTORAGE: id, data, content_type, filename, filesize, description
	// PROPOSED:  id, location, type, filename, description
	// List of extensions at end of file
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('//string','type'),
			DBColumn::make('//string','filename'),
			DBColumn::make('text','description')
			);
		return parent::createTable ('files', __CLASS__, $cols);
	}

	static function make($id = null) {return parent::make(__CLASS__, $id);}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	function getSize() {return filesize($this->getDirectoryFile());}
	function getDirectoryFile() {return $this->getDirectory() . $this->getFilename();}
	function getDirectory() {
		$id = (string) $this->getId();
		if (1&strlen($id)) $id = "0$id";
		$path = implode('/', $str_split($id,2));
		return DATA_STORAGE_DIR . "$path/";
	}

	function getLocalFilename() {
		// Replaces the extension with one matching the mime type, if available
		$filename = $this->getFilename();
		if (!$filename) return "file.tmp";

		$pos = strrpos ('.', $filename);
		if ($pos === false) return "$filename.tmp";
		$type = $this->getType();
		$ext = @$extensions[$type];
		if (!$ext) $ext = substr ($filename, 1+$pos);
		if (!$ext) $ext = "tmp";
		return substr($filename, 0, $pos) . ".$ext";
	}
	
	function insert($data) {
		if ($data instanceof HTML_QuickForm_file) {$data = $data->getValue();}

		// First check if there is a file available for upload
		$tmp = $data['tmp_name'];
		if (!is_readable ($data['tmp_name'])) {
			error_log ("Upload of file $tmp failed.");
			return false;
		}

		// Assume the file is uploaded (for now) and set up the file object; need to save() to get a new id.

		$this->setType ($data['type']);
		$this->setFilename ($data['name']);
		if (!$this->getId()) $this->save();
		if (!$this->getId()) {
			error_log ("Save failed in File.php");
			return false;
		}
		$dir = $this->getDirectory();
		$file = $this->getLocalFilename();
		mkdir($dir,777,true);
		if (!move_uploaded_file ($data['tmp_name'], $dir.$file)) {
			error_log ("Upload of file $tmp to $loc failed.");
			return false;
		}
	}

	function getAddEditFormHook($form) {
		$form->addElement ('file', 'upload_file', 'Upload file');
	}
	
	function getAddEditFormSaveHook($form) {
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
}
DBRow::init('File');
