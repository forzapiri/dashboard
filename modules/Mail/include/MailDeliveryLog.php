<?php
/**
 * MailDeliveryLog
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
class MailDeliveryLog {

	/**
	 * Variable associated with `id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Variable associated with `user_id` column in table.
	 *
	 * @var string
	 */
	protected $user = null;
	
	/**
	 * Variable associated with `mso_id` column in table.
	 *
	 * @var string
	 */
	protected $sendOut = null;
	
	/**
	 * Variable associated with `mail_queue_id` column in table.
	 *
	 * @var string
	 */
	protected $queue = null;
	
	/**
	 * Variable associated with `timestamp` column in table.
	 *
	 * @var string
	 */
	protected $timestamp = null;
	
	/**
	 * Create an instance of the MailDeliveryLog class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template MailDeliveryLog object is returned.
	 *
	 * @param int $id
	 * @return MailDeliveryLog object
	 */
	public function __construct( $id = null ) {
		if (!is_null($id)) {
			$sql = 'select * from mail_delivery_log where id=' . $id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setId($result['id']);
			$this->setUser($result['user_id']);
			$this->setSendOut($result['mso_id']);
			$this->setQueue($result['mail_queue_id']);
			$this->setTimestamp($result['timestamp']);
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
	 * Returns the object's User
	 *
	 * @return string
	 */
	public function getUser() {
		return $this->user;
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
	 * Returns the object's Queue
	 *
	 * @return string
	 */
	public function getQueue() {
		return $this->queue;
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
	 * Sets the object's Id
	 *
	 * @param string $id New $this->id value
	 */
	public function setId( $id ) {
		$this->id = $id;
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
	 * Sets the object's SendOut
	 *
	 * @param string $sendOut New $this->sendOut value
	 */
	public function setSendOut( $sendOut ) {
		$this->sendOut = $sendOut;
	}

	/**
	 * Sets the object's Queue
	 *
	 * @param string $queue New $this->queue value
	 */
	public function setQueue( $queue ) {
		$this->queue = $queue;
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
	 * Save the object in the database
	 */
	public function save() {
		if (!is_null($this->getId())) {
			$sql = 'update mail_delivery_log set ';
		} else {
			$sql = 'insert into mail_delivery_log set ';
		}
		if (!is_null($this->getUser())) {
			$sql .= '`user_id`="' . e($this->getUser()) . '", ';
		}
		if (!is_null($this->getSendOut())) {
			$sql .= '`mso_id`="' . e($this->getSendOut()) . '", ';
		}
		if (!is_null($this->getQueue())) {
			$sql .= '`mail_queue_id`="' . e($this->getQueue()) . '", ';
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
		$sql = 'delete from mail_delivery_log where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/MailDeliveryLog') {
		$form = new Form('MailDeliveryLog_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'addedit' ) );
		$form->addElement( 'hidden', 'section' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'maildeliverylog_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'maildeliverylog_id' );
			
			$defaultValues ['maildeliverylog_user'] = $this->getUser();
			$defaultValues ['maildeliverylog_sendOut'] = $this->getSendOut();
			$defaultValues ['maildeliverylog_queue'] = $this->getQueue();
			$defaultValues ['maildeliverylog_timestamp'] = $this->getTimestamp();

			$form->setDefaults( $defaultValues );
		}
					
		$form->addElement('text', 'maildeliverylog_user', 'user');
		$form->addElement('text', 'maildeliverylog_sendOut', 'sendOut');
		$form->addElement('text', 'maildeliverylog_queue', 'queue');
		$form->addElement('text', 'maildeliverylog_timestamp', 'timestamp');
		$form->addElement('submit', 'maildeliverylog_submit', 'Submit');

		if ($form->validate() && $form->isSubmitted()) {
			$this->setUser($form->exportValue('maildeliverylog_user'));
			$this->setSendOut($form->exportValue('maildeliverylog_sendOut'));
			$this->setQueue($form->exportValue('maildeliverylog_queue'));
			$this->setTimestamp($form->exportValue('maildeliverylog_timestamp'));
			$this->save();
		}

		return $form;
		
	}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllMailDeliveryLogs() {
		$sql = 'select `id` from mail_delivery_log';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new MailDeliveryLog($result['id']);
		}
		
		return $results;
	}
	
}
?>