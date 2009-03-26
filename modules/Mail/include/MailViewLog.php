<?php
/**
 * MailViewLog
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
class MailViewLog {

	/**
	 * Variable associated with `id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Variable associated with `user` column in table.
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
	 * Variable associated with `browser` column in table.
	 *
	 * @var string
	 */
	protected $browser = null;
	
	/**
	 * Variable associated with `timestamp` column in table.
	 *
	 * @var string
	 */
	protected $timestamp = null;
	
	protected $browscap = null;
	
	/**
	 * Create an instance of the MailViewLog class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template MailViewLog object is returned.
	 *
	 * @param int $id
	 * @return MailViewLog object
	 */
	public function __construct( $id = null ) {
		if (!is_null($id)) {
			$sql = 'select * from mail_view_log where id=' . $id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setId($result['id']);
			$this->setUser($result['user']);
			$this->setSendOut($result['mso_id']);
			$this->setTimestamp($result['timestamp']);
			
			$browscap= new Browscap('/tmp');
			$this->setBrowser($browscap->getBrowser($result['browser']));
			
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
	 * Returns the object's Browser
	 *
	 * @return string
	 */
	public function getBrowser() {
		return $this->browser;
	}
	
	public function getBrowserIcon() {
		$browser = $this->getBrowser()->Browser;
		
		switch ($browser) {
			case 'Firefox': return '/modules/Mail/images/firefox.png';
			case 'AppleWebKit': return '/modules/Mail/images/safari.png';
			case 'IE': return '/modules/Mail/images/msie.png';
			case 'Mozilla': return '/modules/Mail/images/thunderbird.png';
		}
		return '/modules/Mail/images/unknown.png';
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
		$this->user = new MailUser($user);
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
	 * Sets the object's Browser
	 *
	 * @param string $browser New $this->browser value
	 */
	public function setBrowser( $browser ) {
		$this->browser = $browser;
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
			$sql = 'update mail_view_log set ';
		} else {
			$sql = 'insert into mail_view_log set ';
		}
		if (!is_null($this->getUser())) {
			$sql .= '`user`="' . e($this->getUser()->getId()) . '", ';
		}
		if (!is_null($this->getSendOut())) {
			$sql .= '`mso_id`="' . e($this->getSendOut()) . '", ';
		}
		if (!is_null($this->getBrowser())) {
			$sql .= '`browser`="' . e($this->getBrowser()) . '", ';
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
		$sql = 'delete from mail_view_log where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllMailViewLogs($mso_id) {
		$sql = 'select `id` from mail_view_log where mso_id=' . $mso_id . ' order by timestamp';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new MailViewLog($result['id']);
		}
		
		return $results;
	}
	
}
?>