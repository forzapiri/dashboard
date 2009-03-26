<?php
/**
 * MailUser
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
class MailUser {

	/**
	 * Variable associated with `id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Variable associated with `email` column in table.
	 *
	 * @var string
	 */
	protected $email = null;
	
	/**
	 * Variable associated with `first_name` column in table.
	 *
	 * @var string
	 */
	protected $firstName = null;
	
	/**
	 * Variable associated with `last_name` column in table.
	 *
	 * @var string
	 */
	protected $lastName = null;
	
	/**
	 * Variable associated with `notes` column in table.
	 *
	 * @var string
	 */
	protected $notes = null;
	
	/**
	 * Create an instance of the MailUser class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template MailUser object is returned.
	 *
	 * @param int $id
	 * @return MailUser object
	 */
	public function __construct( $id = null ) {
		if (!is_null($id)) {
			$sql = 'select * from mail_users where id=' . $id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setId($result['id']);
			$this->setEmail($result['email']);
			$this->setFirstName($result['first_name']);
			$this->setLastName($result['last_name']);
			$this->setNotes($result['notes']);
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
	 * Returns the object's Email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Returns the object's FirstName
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Returns the object's LastName
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Returns the object's Notes
	 *
	 * @return string
	 */
	public function getNotes() {
		return $this->notes;
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
	 * Sets the object's Email
	 *
	 * @param string $email New $this->email value
	 */
	public function setEmail( $email ) {
		$this->email = $email;
	}

	/**
	 * Sets the object's FirstName
	 *
	 * @param string $firstName New $this->firstName value
	 */
	public function setFirstName( $firstName ) {
		$this->firstName = $firstName;
	}

	/**
	 * Sets the object's LastName
	 *
	 * @param string $lastName New $this->lastName value
	 */
	public function setLastName( $lastName ) {
		$this->lastName = $lastName;
	}

	/**
	 * Sets the object's Notes
	 *
	 * @param string $notes New $this->notes value
	 */
	public function setNotes( $notes ) {
		$this->notes = $notes;
	}


	/**
	 * Save the object in the database
	 */
	public function save() {
		if (!is_null($this->getId())) {
			$sql = 'update mail_users set ';
		} else {
			$sql = 'insert into mail_users set ';
		}
		if (!is_null($this->getEmail())) {
			$sql .= '`email`="' . e($this->getEmail()) . '", ';
		}
		if (!is_null($this->getFirstName())) {
			$sql .= '`first_name`="' . e($this->getFirstName()) . '", ';
		}
		if (!is_null($this->getLastName())) {
			$sql .= '`last_name`="' . e($this->getLastName()) . '", ';
		}
		if (!is_null($this->getNotes())) {
			$sql .= '`notes`="' . e($this->getNotes()) . '", ';
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
		$sql = 'delete from mail_users where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
		
		$sql = 'delete from mail_users_to_lists where mail_user_id=' . e($this->getId());
		Database::singleton()->query($sql);
	}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/Mail') {
		$form = new Form('MailUser_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'users' ) );
		$form->addElement( 'hidden', 'section' );
		$form->setConstants( array ( 'action' => 'addedit' ) );
		$form->addElement( 'hidden', 'action' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'mailuser_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'mailuser_id' );
			
			$defaultValues ['mailuser_email'] = $this->getEmail();
			$defaultValues ['mailuser_firstName'] = $this->getFirstName();
			$defaultValues ['mailuser_lastName'] = $this->getLastName();
			$defaultValues ['mailuser_notes'] = $this->getNotes();

			$form->setDefaults( $defaultValues );
		}
					
		$form->addElement('text', 'mailuser_email', 'E-Mail Address');
		$form->addElement('text', 'mailuser_firstName', 'First Name');
		$form->addElement('text', 'mailuser_lastName', 'Last Name');
		$form->addElement('tinymce', 'mailuser_notes', 'Notes');
		$form->addElement('submit', 'mailuser_submit', 'Save');

		if ($form->validate() && $form->isSubmitted()) {
			$this->setEmail($form->exportValue('mailuser_email'));
			$this->setFirstName($form->exportValue('mailuser_firstName'));
			$this->setLastName($form->exportValue('mailuser_lastName'));
			$this->setNotes($form->exportValue('mailuser_notes'));
			$this->save();
		}

		return $form;
		
	}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllMailUsers() {
		$sql = 'select `id` from mail_users order by `email`';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new MailUser($result['id']);
		}
		
		return $results;
	}
	
	public function __toString() {
		$str =  $this->getEmail();
		if (!is_null($this->getFirstName()) && !is_null($this->getLastName())) {
			$str .= ' (' . $this->getFirstName() . ' ' . $this->getLastName() . ')';
		}
		return $str;
	}
	
}
?>