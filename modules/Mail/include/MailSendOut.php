<?php
/**
 * MailSendOut
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
class MailSendOut {

	/**
	 * Variable associated with `mso_id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Variable associated with `mso_timestamp` column in table.
	 *
	 * @var string
	 */
	protected $timestamp = null;
	
	/**
	 * Variable associated with `mso_subject` column in table.
	 *
	 * @var string
	 */
	protected $subject = null;
	
	/**
	 * Variable associated with `mso_content` column in table.
	 *
	 * @var string
	 */
	protected $content = null;
	
	/**
	 * Variable associated with `mso_fromName` column in table.
	 *
	 * @var string
	 */
	protected $fromName = null;
	
	/**
	 * Variable associated with `mso_fromAddress` column in table.
	 *
	 * @var string
	 */
	protected $fromAddress = null;
	
	protected $listCount = null;
	
	protected $listName = null;
	
	/**
	 * Create an instance of the MailSendOut class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template MailSendOut object is returned.
	 *
	 * @param int $mso_id
	 * @return MailSendOut object
	 */
	public function __construct( $mso_id = null ) {
		if (!is_null($mso_id)) {
			$sql = 'select * from mail_sendout where mso_id=' . $mso_id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setId($result['mso_id']);
			$this->setTimestamp($result['mso_timestamp']);
			$this->setSubject($result['mso_subject']);
			$this->setContent($result['mso_content']);
			$this->setFromName($result['mso_fromName']);
			$this->setFromAddress($result['mso_fromAddress']);
			$this->setListCount($result['mso_listcount']);
			$this->setListName($result['list_name']);
		}
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
	 * Returns the object's Timestamp
	 *
	 * @return string
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * Returns the object's Subject
	 *
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Returns the object's Content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Returns the object's FromName
	 *
	 * @return string
	 */
	public function getFromName() {
		return $this->fromName;
	}

	/**
	 * Returns the object's FromAddress
	 *
	 * @return string
	 */
	public function getFromAddress() {
		return $this->fromAddress;
	}
	
	public function getListCount() {
		return $this->listCount;
	}
	
	public function getListName() {
		return $this->listName;
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
	 * Sets the object's Timestamp
	 *
	 * @param string $timestamp New $this->timestamp value
	 */
	public function setTimestamp( $timestamp ) {
		$this->timestamp = $timestamp;
	}

	/**
	 * Sets the object's Subject
	 *
	 * @param string $subject New $this->subject value
	 */
	public function setSubject( $subject ) {
		$this->subject = $subject;
	}

	/**
	 * Sets the object's Content
	 *
	 * @param string $content New $this->content value
	 */
	public function setContent( $content ) {
		$this->content = $content;
	}

	/**
	 * Sets the object's FromName
	 *
	 * @param string $fromName New $this->fromName value
	 */
	public function setFromName( $fromName ) {
		$this->fromName = $fromName;
	}

	/**
	 * Sets the object's FromAddress
	 *
	 * @param string $fromAddress New $this->fromAddress value
	 */
	public function setFromAddress( $fromAddress ) {
		$this->fromAddress = $fromAddress;
	}
	
	public function setListCount( $count ) {
		$this->listCount = $count;
	}
	
	public function setListName ( $name ) {
		$this->listName = $name;
	}
	
	public function accept($content) {
		 $this->setTimestamp($content->getLastMod());
		 $this->setSubject($content->getSubject());
		 $this->setContent($content->getContent());
		 $this->setFromName($content->getFromName());
		 $this->setFromAddress($content->getFromAddress());
	}
	
	public function logView($user) {
		// TODO log the view (and create the table :P )
	}


	/**
	 * Save the object in the database
	 */
	public function save() {
		if (!is_null($this->getId())) {
			$sql = 'update mail_sendout set ';
		} else {
			$sql = 'insert into mail_sendout set ';
		}
		if (!is_null($this->getTimestamp())) {
			$sql .= '`mso_timestamp`="' . e($this->getTimestamp()) . '", ';
		}
		if (!is_null($this->getSubject())) {
			$sql .= '`mso_subject`="' . e($this->getSubject()) . '", ';
		}
		if (!is_null($this->getContent())) {
			$sql .= '`mso_content`="' . e($this->getContent()) . '", ';
		}
		if (!is_null($this->getFromName())) {
			$sql .= '`mso_fromName`="' . e($this->getFromName()) . '", ';
		}
		if (!is_null($this->getFromAddress())) {
			$sql .= '`mso_fromAddress`="' . e($this->getFromAddress()) . '", ';
		}
		if (!is_null($this->getListCount())) {
			$sql .= '`mso_listcount`="' . e($this->getListCount()) . '", ';
		}
		if (!is_null($this->getId())) {
			$sql .= 'mso_id="' . e($this->getId()) . '" where mso_id="' . e($this->getId()) . '"';
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
		$sql = 'delete from mail_sendout where mso_id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/MailSendOut') {
		$form = new Form('MailSendOut_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'addedit' ) );
		$form->addElement( 'hidden', 'section' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'mailsendout_mso_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'mailsendout_mso_id' );
			
			$defaultValues ['mailsendout_timestamp'] = $this->getTimestamp();
			$defaultValues ['mailsendout_subject'] = $this->getSubject();
			$defaultValues ['mailsendout_content'] = $this->getContent();
			$defaultValues ['mailsendout_fromName'] = $this->getFromName();
			$defaultValues ['mailsendout_fromAddress'] = $this->getFromAddress();

			$form->setDefaults( $defaultValues );
		}
					
		$form->addElement('text', 'mailsendout_timestamp', 'timestamp');
		$form->addElement('text', 'mailsendout_subject', 'subject');
		$form->addElement('text', 'mailsendout_content', 'content');
		$form->addElement('text', 'mailsendout_fromName', 'fromName');
		$form->addElement('text', 'mailsendout_fromAddress', 'fromAddress');
		$form->addElement('submit', 'mailsendout_submit', 'Submit');

		if ($form->validate() && $form->isSubmitted()) {
			$this->setTimestamp($form->exportValue('mailsendout_timestamp'));
			$this->setSubject($form->exportValue('mailsendout_subject'));
			$this->setContent($form->exportValue('mailsendout_content'));
			$this->setFromName($form->exportValue('mailsendout_fromName'));
			$this->setFromAddress($form->exportValue('mailsendout_fromAddress'));
			$this->save();
		}

		return $form;
		
	}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllMailSendOuts() {
		$sql = 'select `mso_id` from mail_sendout';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new MailSendOut($result['mso_id']);
		}
		
		return $results;
	}
	
}
?>