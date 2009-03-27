<?php
/**
 * MailList
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
class MailList {

	/**
	 * Variable associated with `id` column in table.
	 *
	 * @var string
	 */
	protected $id = null;
	
	/**
	 * Variable associated with `name` column in table.
	 *
	 * @var string
	 */
	protected $name = null;
	
	/**
	 * Create an instance of the MailList class.
	 * 
	 * This takes the primary key as a parameter and builds the object around the
	 * returned row. If the parameter is null, not specified or the row does not
	 * exist then a blank template MailList object is returned.
	 *
	 * @param int $id
	 * @return MailList object
	 */
	public function __construct( $id = null ) {
		if (!is_null($id)) {
			$sql = 'select * from mail_lists where id=' . $id;
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}

			$this->setId($result['id']);
			$this->setName($result['name']);
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
	 * Returns the object's Name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
	 * Sets the object's Name
	 *
	 * @param string $name New $this->name value
	 */
	public function setName( $name ) {
		$this->name = $name;
	}


	/**
	 * Save the object in the database
	 */
	public function save() {
		if (!is_null($this->getId())) {
			$sql = 'update mail_lists set ';
		} else {
			$sql = 'insert into mail_lists set ';
		}
		if (!is_null($this->getName())) {
			$sql .= '`name`="' . e($this->getName()) . '", ';
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
		$sql = 'delete from mail_lists where id="' . e($this->getId()) . '"';
		Database::singleton()->query($sql);
	}

	/**
	 * Get an Add/Edit form for the object.
	 *
	 * @param string $target Post target for form submission
	 */
	public function getAddEditForm($target = '/admin/Mail') {
		$form = new Form('MailList_addedit', 'post', $target);
		
		$form->setConstants( array ( 'section' => 'lists' ) );
		$form->addElement( 'hidden', 'section' );
		$form->setConstants( array ( 'action' => 'addedit' ) );
		$form->addElement( 'hidden', 'action' );
		
		if (!is_null($this->getId())) {
			$form->setConstants( array ( 'maillist_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'maillist_id' );
			
			$defaultValues ['maillist_name'] = $this->getName();

			$form->setDefaults( $defaultValues );
		}
					
		$form->addElement('text', 'maillist_name', 'List Name');
		$form->addElement('submit', 'maillist_submit', 'Submit');

		if ($form->validate() && $form->isSubmitted()) {
			$this->setName($form->exportValue('maillist_name'));
			$this->save();
		}

		return $form;
		
	}
	
	public function getListUsers() {
		$sql = 'select mail_user_id from mail_users_to_lists where mail_list_id=' . $this->getId();
		$rs = Database::singleton()->query_fetch_all($sql);
		foreach ($rs as &$r) {
			$r = new MailUser($r['mail_user_id']);
		}
		return $rs;
	}
	
	/**
	 * Return an array of all existing objects of this type in the database
	 */
	public static function getAllMailLists() {
		$sql = 'select `id` from mail_lists';
		$results = Database::singleton()->query_fetch_all($sql);
		
		foreach ($results as &$result) {
			$result = new MailList($result['id']);
		}
		
		return $results;
	}
	
	public function getListUsersForm() {
		$form = new Form('MailList_users', 'post', '/admin/Mail');
		
		$form->setConstants( array ( 'section' => 'lists' ) );
		$form->addElement( 'hidden', 'section' );
		$form->setConstants( array ( 'action' => 'updateList' ) );
		$form->addElement( 'hidden', 'action' );
		$form->setConstants( array ( 'listId' => $this->getId() ) );
		$form->addElement( 'hidden', 'listId' );
		
		$users = array();
		foreach ($this->getListUsers() as $user) {
			$users[] = $user->getId();
		}
		
		$allusers = array();
		foreach (MailUser::getAllMailUsers() as $user) {
			$allusers[$user->getId()] = $user->__toString();
		}
		
		$form->setDefaults(array('subscribers' =>  $users));
		$ams = $form->addElement('advmultiselect', 'subscribers', null, $allusers, array('style'=>'width: 300px;', 'onblur'=>'changeCallback(this);'));
		
		$ams->setLabel(array($this->getName(), 'Available', 'Subscribed to List'));
		
		if ($form->validate() && $form->isSubmitted()) {
			$clean = $form->getSubmitValues(); 
			
			if (isset($_REQUEST['subscribers-t'])) {
				foreach ($_REQUEST['subscribers-t'] as $from) {
					$this->removeListUser($from);
				}
			}
			
			if (isset($_REQUEST['subscribers-f'])) {
				foreach ($_REQUEST['subscribers-f'] as $from) {
					$this->addListUser($from);
				}
			}
		}
		
		return $form;
	}
	
	public function queueUsers($sendout) {
		foreach ($this->getListUsers() as $user) {
			$itm = new MailQueue();
			$itm->setUser($user->getId());
			$itm->setSendOut($sendout->getId());
			$itm->save();
		}
	}
	
	public function getListCount() {
		$sql = 'select count(*) as count from mail_users_to_lists where mail_list_id=' . e($this->getId());
		$r = Database::singleton()->query_fetch($sql);
		
		return $r['count'];
	}
	
	public function addListUser($uid) {
		$sql = 'insert into mail_users_to_lists set mail_list_id=' . $this->getId() . ', mail_user_id=' . e($uid);
		Database::singleton()->query($sql);
	}
	
	public function removeListUser($uid) {
		$sql = 'delete from mail_users_to_lists where mail_list_id=' . $this->getId() . ' and mail_user_id=' . e($uid);
		Database::singleton()->query($sql);
	}
}
?>