<?php
/**
 * Templates
 * @author Christopher Troup <chris@norex.ca>
 * @package CMS
 * @version 2.0
 */

/**
 * DETAILED CLASS TITLE
 * 
 * DETAILED DESCRIPTION OF THE CLASS
 * @package CMS
 * @subpackage Core
 */
class Template {

	/**
	 * Variable associated with `module` column in table.
	 *
	 * @var string
	 */
	protected $module = null;
	
	/**
	 * Variable associated with `path` column in table.
	 *
	 * @var string
	 */
	protected $path = null;
	
	/**
	 * Variable associated with `data` column in table.
	 *
	 * @var string
	 */
	protected $data = null;
	
	/**
	 * Variable associated with `timestamp` column in table.
	 *
	 * @var string
	 */
	protected $timestamp = null;
	
	/**
	 * Variable associated with `id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Create an instance of the Templates class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template Templates object is returned.
	 *
	 * @param int $id
	 * @return Templates object
	 */
	public function __construct( $id = null ) {
		if (!is_null($id)) {
			$sql = 'select * from templates where id=' . $id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setModule($result['module']);
			$this->setPath($result['path']);
			$this->setData($result['data']);
			$this->setTimestamp($result['timestamp']);
			$this->setId($result['id']);
		}
	}

	/**
	 * Returns the object's Module
	 *
	 * @return string
	 */
	public function getModule() {
		return $this->module;
	}
	
	public function getModuleName() {
		if ($this->getModule() == 'CMS') {
			return 'CMS';
		}
		return substr($this->getModule(), 7);
	}
	
	/**
	 * Returns the object's Path
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Returns the object's Data
	 *
	 * @return string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Returns the object's Timestamp
	 *
	 * @return string
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * Returns the object's Id
	 *
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Sets the object's Module
	 *
	 * @param string $module New $this->module value
	 */
	public function setModule( $module ) {
		$this->module = $module;
	}

	/**
	 * Sets the object's Path
	 *
	 * @param string $path New $this->path value
	 */
	public function setPath( $path ) {
		$this->path = $path;
	}

	/**
	 * Sets the object's Data
	 *
	 * @param string $data New $this->data value
	 */
	public function setData( $data ) {
		$this->data = $data;
	}

	/**
	 * Sets the object's Timestamp
	 *
	 * @param string $timestamp New $this->timestamp value
	 */
	public function setTimestamp( $timestamp ) {
		$this->timestamp = $timestamp;
	}

	/**
	 * Sets the object's Id
	 *
	 * @param string $id New $this->id value
	 */
	public function setId( $id ) {
		$this->id = $id;
	}


	/**
	 * Save the object in the database
	 */
	public function save() {
		if (!is_null($this->getId())) {
			$sql = 'update templates set ';
		} else {
			$sql = 'insert into templates set ';
		}
		if (!is_null($this->getModule())) {
			$sql .= '`module`="' . e($this->getModule()) . '", ';
		}
		if (!is_null($this->getPath())) {
			$sql .= '`path`="' . e($this->getPath()) . '", ';
		}
		if (!is_null($this->getData())) {
			$sql .= '`data`="' . e($this->getData()) . '", ';
		}
		if (!is_null($this->getTimestamp())) {
			$sql .= '`timestamp`="' . e($this->getTimestamp()) . '", ';
		}
		if (!is_null($this->getId())) {
			$sql .= 'id="' . e($this->getId()) . '" where id="' . e($this->getId()) . '"';
		} else {
			$sql = trim($sql, ', ');
		}
		Database::singleton()->query($sql);
		if (is_null($this->getId())) {
			$this->setId(Database::singleton()->lastInsertedID());
			self::__construct($this->getId());
		}
	}

	/**
	 * Delete the object from the database
	 */
	public function delete() {
		$sql = 'delete from templates where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/Templates') {
		$form = new Form('Templates_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'addedit' ) );
		$form->addElement( 'hidden', 'section' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'templates_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'templates_id' );
			
			$defaultValues ['templates_module'] = $this->getModule();
			$defaultValues ['templates_path'] = $this->getPath();
			$defaultValues ['templates_data'] = $this->getData();
			$defaultValues ['templates_timestamp'] = $this->getTimestamp();

			$form->setDefaults( $defaultValues );
		}
					
		$form->addElement('text', 'templates_module', 'module');
		$form->addElement('text', 'templates_path', 'path');
		$form->addElement('text', 'templates_data', 'data');
		$form->addElement('text', 'templates_timestamp', 'timestamp');
		$form->addElement('submit', 'templates_submit', 'Submit');

		if ($form->validate() && $form->isSubmitted()) {
			$this->setModule($form->exportValue('templates_module'));
			$this->setPath($form->exportValue('templates_path'));
			$this->setData($form->exportValue('templates_data'));
			$this->setTimestamp($form->exportValue('templates_timestamp'));
			$this->save();
		}

		return $form;
		
	}
	
	public function getRevisions() {
		$sql = 'select `id` from templates where `module`="' . $this->getModule() . '" and `path`="' . $this->getPath() . '" order by `timestamp` desc';
		
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new Template($result['id']);
		}
		
		return $results;
	}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllTemplates() {
		$sql = 'select id from (select id, path, module from templates order by `timestamp` desc) b group by path order by module, path';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new Template($result['id']);
		}
		
		return $results;
	}
	
}
?>