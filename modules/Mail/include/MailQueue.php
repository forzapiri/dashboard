<?php

/**
 * MailQueue
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
class MailQueue {

	/**
	 * Variable associated with `mso_id` column in table.
	 *
	 * @var string
	 */
	protected $sendOut = null;
	
	/**
	 * Variable associated with `mail_user_id` column in table.
	 *
	 * @var string
	 */
	protected $user = null;
	
	/**
	 * Variable associated with `id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Create an instance of the MailQueue class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template MailQueue object is returned.
	 *
	 * @param int $id
	 * @return MailQueue object
	 */
	public function __construct( $id = null ) {
		if (!is_null($id)) {
			$sql = 'select * from mail_queue where id=' . $id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setSendOut($result['mso_id']);
			$this->setUser($result['mail_user_id']);
			$this->setId($result['id']);
		}
	}

	/**
	 * Returns the object's SendOut
	 *
	 * @return string
	 */
	public function getSendOut() {
		return $this->sendOut;
	}

	/**
	 * Returns the object's User
	 *
	 * @return string
	 */
	public function getUser() {
		return $this->user;
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
	 * Sets the object's SendOut
	 *
	 * @param string $sendOut New $this->sendOut value
	 */
	public function setSendOut( $sendOut ) {
		$this->sendOut = $sendOut;
	}

	/**
	 * Sets the object's User
	 *
	 * @param string $user New $this->user value
	 */
	public function setUser( $user ) {
		$this->user = $user;
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
			$sql = 'update mail_queue set ';
		} else {
			$sql = 'insert into mail_queue set ';
		}
		if (!is_null($this->getSendOut())) {
			$sql .= '`mso_id`="' . e($this->getSendOut()) . '", ';
		}
		if (!is_null($this->getUser())) {
			$sql .= '`mail_user_id`="' . e($this->getUser()) . '", ';
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
		$sql = 'delete from mail_queue where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/MailQueue') {
		$form = new Form('MailQueue_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'addedit' ) );
		$form->addElement( 'hidden', 'section' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'mailqueue_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'mailqueue_id' );
			
			$defaultValues ['mailqueue_sendOut'] = $this->getSendOut();
			$defaultValues ['mailqueue_user'] = $this->getUser();

			$form->setDefaults( $defaultValues );
		}
					
		$form->addElement('text', 'mailqueue_sendOut', 'sendOut');
		$form->addElement('text', 'mailqueue_user', 'user');
		$form->addElement('submit', 'mailqueue_submit', 'Submit');

		if ($form->validate() && $form->isSubmitted()) {
			$this->setSendOut($form->exportValue('mailqueue_sendOut'));
			$this->setUser($form->exportValue('mailqueue_user'));
			$this->save();
		}

		return $form;
		
	}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllMailQueues($limit = null) {
		$sql = 'select `id` from mail_queue';
		if (!is_null($limit)) {
			$sql .= ' limit ' . $limit;
		}
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new MailQueue($result['id']);
		}
		return $results;
	}
	
}

?>