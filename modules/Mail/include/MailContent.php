<?php

/**
 * MailContent
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
class MailContent {

	/**
	 * Variable associated with `mail_id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Variable associated with `mail_subject` column in table.
	 *
	 * @var string
	 */
	protected $subject = null;
	
	/**
	 * Variable associated with `mail_content` column in table.
	 *
	 * @var string
	 */
	protected $content = null;
	
	/**
	 * Variable associated with `mail_lastmod` column in table.
	 *
	 * @var string
	 */
	protected $lastMod = null;
	
	/**
	 * Variable associated with `mail_from_name` column in table.
	 *
	 * @var string
	 */
	protected $fromName = null;
	
	/**
	 * Variable associated with `mail_from_address` column in table.
	 *
	 * @var string
	 */
	protected $fromAddress = null;
	
	/**
	 * Create an instance of the MailContent class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template MailContent object is returned.
	 *
	 * @param int $mail_id
	 * @return MailContent object
	 */
	public function __construct( $mail_id = null ) {
		if (!is_null($mail_id)) {
			$sql = 'select * from mail_content where mail_id=' . $mail_id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setId($result['mail_id']);
			$this->setSubject($result['mail_subject']);
			$this->setContent($result['mail_content']);
			$this->setLastMod($result['mail_lastmod']);
			$this->setFromName($result['mail_from_name']);
			$this->setFromAddress($result['mail_from_address']);
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
	 * Returns the object's LastMod
	 *
	 * @return string
	 */
	public function getLastMod() {
		return $this->lastMod;
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

	/**
	 * Sets the object's Id
	 *
	 * @param string $id New $this->id value
	 */
	public function setId( $id ) {
		$this->id = $id;
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
	 * Sets the object's LastMod
	 *
	 * @param string $lastMod New $this->lastMod value
	 */
	public function setLastMod( $lastMod ) {
		$this->lastMod = $lastMod;
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


	/**
	 * Save the object in the database
	 */
	public function save() {
		if (!is_null($this->getId())) {
			$sql = 'update mail_content set ';
		} else {
			$sql = 'insert into mail_content set ';
		}
		if (!is_null($this->getSubject())) {
			$sql .= '`mail_subject`="' . e($this->getSubject()) . '", ';
		}
		if (!is_null($this->getContent())) {
			$sql .= '`mail_content`="' . e($this->getContent()) . '", ';
		}
		//if (!is_null($this->getLastMod())) {
		//	$sql .= '`mail_lastmod`="' . e($this->getLastMod()) . '", ';
		//}
		if (!is_null($this->getFromName())) {
			$sql .= '`mail_from_name`="' . e($this->getFromName()) . '", ';
		}
		if (!is_null($this->getFromAddress())) {
			$sql .= '`mail_from_address`="' . e($this->getFromAddress()) . '", ';
		}
		if (!is_null($this->getId())) {
			$sql .= 'mail_id="' . e($this->getId()) . '" where mail_id="' . e($this->getId()) . '"';
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
		$sql = 'delete from mail_content where mail_id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/Mail') {
		$form = new Form('MailContent_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'content' ) );
		$form->addElement( 'hidden', 'section' );
		$form->setConstants( array ( 'action' => 'addedit' ) );
		$form->addElement( 'hidden', 'action' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'mailcontent_mail_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'mailcontent_mail_id' );
			
			$defaultValues ['mailcontent_subject'] = $this->getSubject();
			$defaultValues ['mailcontent_content'] = $this->getContent();
			//$defaultValues ['mailcontent_lastMod'] = $this->getLastMod();
			$defaultValues ['mailcontent_fromName'] = $this->getFromName();
			$defaultValues ['mailcontent_fromAddress'] = $this->getFromAddress();

			$form->setDefaults( $defaultValues );
		}
					
		$form->addElement('text', 'mailcontent_subject', 'Mail Subject Line');
		$form->addElement('text', 'mailcontent_fromName', 'From Name');
		$form->addElement('text', 'mailcontent_fromAddress', 'From Address');
		$form->addElement('tinymce', 'mailcontent_content', 'Mail Content', array('style'=>'width: 100px;'));
		//$form->addElement('text', 'mailcontent_lastMod', 'Last Modified');
		
		$form->addElement('submit', 'mailcontent_submit', 'Submit');

		if ($form->validate() && $form->isSubmitted()) {
			$this->setSubject($form->exportValue('mailcontent_subject'));
			$this->setContent($form->exportValue('mailcontent_content'));
			//$this->setLastMod($form->exportValue('mailcontent_lastMod'));
			$this->setFromName($form->exportValue('mailcontent_fromName'));
			$this->setFromAddress($form->exportValue('mailcontent_fromAddress'));
			$this->save();
		}

		return $form;
		
	}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllMailContents() {
		$sql = 'select `mail_id` from mail_content order by mail_lastmod desc';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new MailContent($result['mail_id']);
		}
		
		return $results;
	}
	
}

?>