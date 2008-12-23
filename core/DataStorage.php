<?php

class DataStorage {
	
	protected $id = null;
		
	protected $data = null;
		
	protected $type = null;
		
	protected $name = null;
		
	protected $size = null;
		
	protected $description = null;
		
	protected $tags = null;
	
	public function __construct( $id = null ) {
	if (!is_null($id)) {
			$sql = 'select * from datastorage where id=' . $id;

			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}
			
			$this->setId($result['id']);
			$this->setData($result['data']);
			$this->setType($result['content_type']);
			$this->setName($result['filename']);
			$this->setSize($result['filesize']);
			$this->setDescription($result['description']);
			
			$sql = 'select tags from datastorage_search where file_id=' . $id;
			if ($result = Database::singleton()->query_fetch_all($sql)) {
				$this->setTags($result);
			}
			
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getSize() {
		return $this->size;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getTags(){
		return $this->tags;
	}

	public function setId( $id ) {
		$this->id = $id;
	}
	
	public function setData( $data ) {
		$this->data = $data;
	}
	
	public function setType( $type ) {
		$this->type = $type;
	}
	
	public function setName( $name ) {
		$this->name = $name;
	}
	
	public function setSize( $size ) {
		$this->size = $size;
	}
	
	public function setDescription( $description ) {
		$this->description = $description;
	}
	
	public function setTags( $tags ){
		$this->tags = $tags;
	}
	
	public function addTag($tag) {
		$sql = 'insert into datastorage_search set file_id=' . $this->getId() . ', tags="' . $tag . '"';
		Database::singleton()->query($sql);
	}
	
	public function save(){
		if (!is_null($this->id)) {
			$sql = 'update datastorage set ';
		} else {
			$sql = 'insert into datastorage set ';
		}
		$sql .= '`data`="' . addslashes($this->data) . '", ';
		$sql .= '`content_type`="' . e($this->type) . '", ';
		$sql .= '`filename`="' . e($this->name) . '", ';
		$sql .= '`filesize`="' . e($this->size) . '", ';
		$sql .= '`description`="' . e($this->getDescription()) . '", ';
		if (!is_null($this->id)) {
			$sql .= 'id="' . e($this->id) . '" where id="' . $this->id . '"';
		} else {
			$sql = trim($sql, ', ');
		}
		Database::singleton()->query($sql);
		//echo $sql;
		if (!is_null($this->id)) {
			$idTemp = $this->id;
		} else {
			$idTemp = Database::singleton()->lastInsertedID();
		}
		
		if (is_null($this->id)) {
			$this->setId($idTemp);
			self::__construct($this->id);
		}
	}
	
	public static function getAllTags() {
		$sql = 'select tags from datastorage_search group by tags order by tags';
		return Database::singleton()->query_fetch_all($sql);
	}
	
	public function delete() {
		$sql = 'delete from datastorage where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
		$sql = 'delete from datastorage_search where file_id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}
	
	public static function search ( $tags = null ){
		if(is_null($tags)){
			$sql = 'select id from datastorage';
			$files = Database::singleton()->query_fetch_all($sql);
		} else {
			$sql = 'select file_id from datastorage_search where tags="' . $tags . '"';
			$files = Database::singleton()->query_fetch_all($sql);
		}
		if(!is_null($files)){
			foreach($files as &$file){
				if(is_null($tags)){
					$file = new DataStorage($file['id']);
				} else {
					$file = new DataStorage($file['file_id']);
				}
			}
			
			return $files;
		} else {
			return null;
		}
	}
	
	public function removeTag($tag) {
		$sql = 'delete from datastorage_search where file_id=' . $this->getId() . ' and tags="' . e($tag) . '"';
		Database::singleton()->query($sql);		
	}
	
	public function insert($data) {
		if ($data instanceof HTML_QuickForm_file) {
			$data = $data->getValue();
		}
		$fp = fopen($data['tmp_name'], 'r');
		$content = fread($fp, filesize($data['tmp_name']));
		//$content = addslashes($content);
		fclose($fp);
		
		$this->setData($content);
		$this->setType($data['type']);
		$this->setName($data['name']);
		$this->setSize(filesize($data['tmp_name']));
	}
	
	public function render() {
		$sql = 'select * from `datastorage` WHERE id="'.$this->getId().'"';
		$fileData = Database::singleton()->query_fetch($sql);

		header("Content-type: $fileData[content_type]");
		header("Content-length: $fileData[filesize]");
		header("Content-Disposition: inline; filename=" . $fileData['filename']);
		echo $fileData['data'];
	}
	
	public function getAddEditForm($target = '/admin/DMS') {
		$form = new Form('DataStorage_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'addedit' ) );
		$form->addElement( 'hidden', 'section' );

		if (!is_null($this->id)) {
			$form->setConstants( array ( 'datastorage_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'datastorage_id' );
				
			//$defaultValues ['datastorage_tags'] = $this->getTags();
			$defaultValues ['datastorage_description'] = $this->getDescription();

			$form->setDefaults( $defaultValues );
		}
			
		$fupload = $form->addElement('file', 'datastorage_file', 'File');
		//$form->addElement('select', 'datastorage_tags', 'Tags', array('sdf', 'sdfsdf'));
		$form->addElement('textarea', 'datastorage_description', 'Description');
		$form->addElement('submit', 'datastorage_submit', 'Submit');
		if(is_null($this->id)){
			$form->addRule('datastorage_file', 'Please upload a file', 'uploadedfile');
		}

		if ($form->validate() && $form->isSubmitted() && isset($_REQUEST['datastorage_submit'])) {
			//$this->setTags(trim($form->exportValue('datastorage_tags')));
			$this->setDescription($_REQUEST['datastorage_description']);
			if ($fupload->isUploadedFile() && isset($_FILES['datastorage_file'])) {
				$this->insert($_FILES['datastorage_file']);
			}
			$this->save();
		}

		return $form;

	}
	
	public static function getImagesList() {
		$sql = 'select id, content_type, filename, filesize from images';
		$images = Database::singleton()->query_fetch_all($sql);
		
		//foreach ($images as &$image) {
		//	$image = new Image(array('id' =>$image['id']));
		//	$image->data = null;
		//}
		return $images;
	}
	
	public function getFileIcon( ){
		$extension = explode('.', $this->getName());
		$extension = $extension[count($extension)-1];
		
		$contype = explode('/', $this->getType());
		$contype = $contype[0];
		
		if($contype == 'image'){
			return 'drawing.png';
		} else if($contype == 'audio'){
			return 'audio_basic.png';
		} else {
			$fileIcon['doc'] = 'application_vnd.ms_word.png';
			$fileIcon['ppt'] = 'application_vnd.ms_powerpoint.png';
			$fileIcon['xls'] = 'application_vnd.ms_excel.png';
			$fileIcon['pdf'] = 'application_pdf.png';
			$fileIcon['rss'] = 'application_rss+xml.png';
			$fileIcon['xml'] = 'xml.png';
			$fileIcon['rtf'] = 'application_rtf.png';
			$fileIcon['zip'] = 'application_x_ar.png';
			$fileIcon['rar'] = $fileIcon['zip'];
			$fileIcon['iso'] = 'application_x_cd_image.png';
			$fileIcon['img'] = $fileIcon['iso'];
			$fileIcon['exe'] = 'application_x_desktop.png';
			$fileIcon['flv'] = 'flv.png';
			$fileIcon['txt'] = 'text_plain.png';
			foreach($fileIcon as $ext => $icon){
				if($ext == $extension){
					return $icon;
				}
			}
			return false;
		}
	}
	
	public static function fileBrowser($type) {
		$tinyMCE = new TinyMCE();
		global $smarty;
		$smarty->assign('type', $type);
		 if(@!is_null($_POST['uploadsubmit'])){
			if(!empty($_FILES['filebrowser_uploadedfile']['name'])){
				if($_POST['uploadtype'] == 'image'){
					$newFile = new Image();
					$newFile->insert($_FILES['filebrowser_uploadedfile']);
					$smarty->assign('type', 'image');
				} else {
					$newFile = new DataStorage();
					$newFile->insert($_FILES['filebrowser_uploadedfile']);
					$newFile->save();
				}
			}
		}
		$smarty->template_dir = SITE_ROOT . '/cms/templates';
		
		$smarty->addJS($tinyMCE->basepath . '/tiny_mce/tiny_mce_popup.js');
		$smarty->addJS($tinyMCE->basepath . '/tiny_mce/utils/mctabs.js');
		$smarty->addCSS($tinyMCE->basepath . '/tiny_mce/themes/advanced/skins/default/dialog.css');
		$smarty->addCSS('/css/tiny_mce_filebrowser.css');
		switch ($type) {
			case 'file':
				$smarty->assign('files', DataStorage::search());
				break;
			default:
				$smarty->assign('images', DataStorage::getImagesList());
				break;
		}
		return $smarty->render('filebrowser.tpl');
	}
		
}

if (isset($_REQUEST['browser'])) {
	include ('../include/Site.php');
	
	echo DataStorage::fileBrowser($_REQUEST['type']);
}

if(isset($_REQUEST['id'])){
	include_once('../include/Site.php');
	
	$fl = new DataStorage($_REQUEST['id']);
	$fl->render();
}

?>