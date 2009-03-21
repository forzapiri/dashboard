<?php
/**
 * User Module
 * @author Christopher Troup <chris@norex.ca>
 * @package Modules
 * @version 2.0
 */

/**
 * User Module
 * 
 * Provide user management for the core CMS
 * @package Modules
 * @subpackage User
 */
class Module_User extends Module {
	
	public $icon = '/images/admin/user.png';
	
	protected $group_dispatcher = null;

	
	public function __construct() {
		parent::__construct();
		$this->page = new Page();
		$this->page->with('User')
			->filter ("where username!='norex'")
			 ->show(array(
			 	'Username' => 'username',
			 	'Name' => 'name',
			 	'Last Name' => 'last_name',
			 	'E-Mail Address' => 'email',
			 	'Group Name' => array('group', array('Group', 'getName')),
			 	'Status' => 'status'))
			 ->name('User')
			 ->heading('User Management');
			 
		$this->page->with('Group')
			 ->show(array(
			 	'Name' => 'name',
			 	'Members' => array('id', array('Group', 'getCountMembers'))))
			 ->name('Group')
			 ->heading('Group Management');
			 
			 
		$this->page->with('Permission')
			 ->heading('Permission Management');
			 
		$this->page->with('User');
	}
	
	/**
	 * Build and return admin interface
	 *
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getAdminInterface() {
		$this->addJS('/modules/User/js/admin.js');

		return $this->page->render('', $this->getPermissionsInterface());
	}

	function getPermissionsInterface() {
		// CHECK PERMISSIONS FOR MODULE
		if (@$_REQUEST['section'] !== 'Permission') return "";
		
		$handler = new PermHandler();
		$groups = Group::getAll();
		if (!$groups) return "";

		$selected = (integer) @$_REQUEST['group'];
		$selected = $selected ? Group::make($selected) : $groups[0];

		switch (@$_REQUEST['perm_action']) {
		case 'toggle':
			if ($selected->getName() == 'Administrator') break; // Don't allow edits to Administrator group
			if (!$this->user->hasPerm('Permission', 'addedit')) break;
			$class = $_REQUEST['class'];
			$key = $_REQUEST['key'];
			$group = $selected->getId();
			if (!$handler->exists($class, $key)) break;
			$p = $handler->getPerm($group, $class, $key);
			$p->toggle();
			$p->save();
		default:
		}

		$query = new Query('select class from permissions group by class order by class', '');
		$classes = $query->fetchAll();
		foreach ($classes as &$class) $class = $class['class'];

		$this->smarty->assign('groups', $groups);
		$this->smarty->assign('selected', $selected);
		$this->smarty->assign('classes', $classes);
		$this->smarty->assign('perms', array('view' => 'View', 'delete' => 'Delete', 'addedit' => 'Add/Edit'));
		$this->smarty->assign('permHandler', new PermHandler());
		
		return ($this->smarty->fetch('admin/permissions.tpl'));
	}
	
	public function setupList($class, $all = null) {
		$method = 'getAll'; // . $all . $class . 's';
		$a = call_user_func(array($class, $method));	
		$this->smarty->assign(strtolower($class) . 's', $a);
	}
	
	
	public function setupMainList() {
		$users = User::getAll();
		$this->smarty->assign('users', $users);
	}

	public function getUserInterface($params = null) {
		$this->addJS('/modules/User/js/user.js');
		require_once(SITE_ROOT . '/core/PEAR/Auth.php');
		switch (@$_REQUEST['section']) {
			/*
			 * Publicly Accessable Pages
			 */
			case 'details_check':
				$sql = 'select * from auth where username="' . e($_REQUEST['username']) . '"';
				$r = Database::singleton()->query_fetch($sql);
				if ($r) {
					echo json_encode(true);
				} else {
					echo json_encode(false);
				}
				die();
				return;
			case 'signup':
				$u = DBRow::make(null,"User");
				$form = $u->getAddEditForm('/user/signup');
				$this->smarty->assign('form', $form);
				
				$form->removeElement($u->quickformPrefix() . 'group');
				$form->removeElement($u->quickformPrefix() . 'status');
				
				$form->addRule($u->quickformPrefix() . 'password', 'Please enter a password', 'required', null, 'client');

				if ($form->isProcessed() && !$form->isResubmit() && $form->validate()) {
					$salt = uniqid('norexcms', true);
					$u->set('salt', $salt);
					$u->set('password', (md5($_REQUEST[$u->quickformPrefix() . 'password'] . md5($salt))));
					$u->set('status', 1);
					$u->save();
					
					$_POST['username'] = $_POST[$u->quickformPrefix() . 'username'];
					$_POST['password'] = $_POST[$u->quickformPrefix() . 'password'];
					$_POST['doLogin'] = "Login";

					$a = new CMSAuthContainer();
					$auth = new Auth($a, null, 'authHTML');
					$auth->start();
					$auth->checkAuth();

					header ('Location: /user/');
				}
				$this->smarty->assign('form', $form);
				return $this->smarty->fetch('account_signup.tpl');
				break;
			
			case 'logout':
				User::logout();
			default:
				if(@$_SESSION['authenticated_user']){
					$u =& $_SESSION['authenticated_user'];
					$form = $u->getAddEditForm('/user/');
					$form->removeElement($u->quickformPrefix() . 'group');
					$form->removeElement($u->quickformPrefix() . 'username');
					$form->removeElement($u->quickformPrefix() . 'status');
					
					if (isset($_REQUEST[$u->quickformPrefix() . 'submit']) && isset($_REQUEST[$u->quickformPrefix() . 'password']) && $_REQUEST[$u->quickformPrefix() . 'password'] != '') {
						$salt = uniqid('norexcms', true);
						$u->set('salt', $salt);
						$u->set('password', (md5($_REQUEST[$u->quickformPrefix() . 'password'] . md5($salt))));
						$u->set('status', 1);
						$u->save();
					} 
					
					if (isset($_REQUEST[$u->quickformPrefix() . 'submit'])) {
						$u->set('name', $_REQUEST[$u->quickformPrefix() . 'name']);
						$u->set('last_name', $_REQUEST[$u->quickformPrefix() . 'last_name']);
						$u->set('email', $_REQUEST[$u->quickformPrefix() . 'email']);
						$u->save();
						unset($form);
						$form = $u->getAddEditForm('/user/');
						$form->removeElement($u->quickformPrefix() . 'group');
						$form->removeElement($u->quickformPrefix() . 'username');
						$form->removeElement($u->quickformPrefix() . 'status');
					}
					
					$this->smarty->assign('form', $form);
					$this->smarty->assign('user', $u);
					return $this->smarty->fetch('account.tpl');
					//header('Location: /');
					exit;
				}
				return authInlineHTML();
				header('Location: /user/signup');
		}
	}

	public function getUserAddEditForm($target = '/admin/User', $admin = false) {
		
		$form = new Form( 'user_addedit', 'POST', $target, '',
		array ( 'class' => 'admin' ) );

		$form->setConstants( array ( 'section' => 'user' ) );
		$form->addElement( 'hidden', 'section' );
		$form->setConstants( array ( 'action' => 'addedit' ) );
		$form->addElement( 'hidden', 'action' );

		if (@$_REQUEST ['id']) {
			$user = User::make($_REQUEST['id']);
			$form->setConstants( array ( 'id' => $_REQUEST ['id'] ) );
			$form->addElement( 'hidden', 'id' );
		}
		else {
			$user = User::make();
		}

		$statuses = array (1 => 'Active', 0 => 'Disabled');		
		
		$form->addElement( 'text', 'a_username', 'Username');
		$form->addElement( 'password', 'a_password', 'Password');
		$form->addElement( 'password', 'a_password_confirm', 'Confirm Password');
		$form->addElement( 'text',  'a_name', 'Full Name');
		$form->addElement( 'text',  'a_email', 'Email Address');
		
		if ($admin)
			$form->addElement( 'select', 'a_status', 'Active Status', $statuses);

		if (isset($this->user) && $this->user->hasPerm('assigngroups')) {
			$sql = 'SELECT agp_id, agp_name from auth_groups';
			$groups = Database::singleton()->query_fetch_all($sql);
			$assignableGroup = array ( );
			foreach ( $groups as $group ) {
				$assignableGroup [$group ['agp_id']] = $group ['agp_name'];
			}
			if (@$user) {
				$defaultValues['a_group'] = $user->getGroup()->getId();
			}
			$form->addElement( 'select',  'a_group', 'Member Group', $assignableGroup);
		}
		
		$form->addElement( 'submit', 'a_submit', 'Save' );


		
		$defaultValues ['a_username'] = $user->getUsername();
		$defaultValues ['a_name'] = $user->getName();
		$defaultValues ['a_email'] = $user->getEmail();
		$defaultValues ['a_password'] = null;
		$defaultValues ['a_password_confirm'] = null;
		
		if ($admin)
			$defaultValues ['a_status'] = $user->getActiveStatus();
		
		$form->setDefaults( $defaultValues );
				

		$form->addRule( 'a_username', 'Please enter a username', 'required', null );
		$form->addRule( 'a_name', 'Please enter the user\'s name', 'required', null );
		$form->addRule( 'a_email', 'Please enter an email address', 'required', null );
		$form->addRule( 'a_email', 'Please enter a valid email address', 'email', null );
		if (!isset($_REQUEST ['id'])) {
			$form->addRule( 'a_password', 'Please enter a password', 'required', null );
			$form->addRule( 'a_password_confirm', 'Please confirm the passwords match', 'required', null );
		}
		$form->addRule(array('a_password', 'a_password_confirm'), 'The passwords do not match', 'compare', null);

		if (isset( $_REQUEST ['a_submit'] ) && $form->validate()) {
			$this->template = 'admin/user.tpl';
			$this->doUserSubmit();
		}
		return $form;
	}
	
	public function doUserSubmit() {
		//Deciding whether this is an update or a new user.
		if (@isset( $_REQUEST ['id'] )) {
			$user = User::make($_REQUEST['id']);
			if ($_REQUEST['a_password'] != '') {
				$user->setPassword($_REQUEST['a_password']);
			}
		} else {
			$user = User::make();
			$user->setPassword($_REQUEST['a_password']);
				
		}
		$user->setUsername($_REQUEST['a_username']);
		$user->setName($_REQUEST['a_name']);
		$user->setEmail($_REQUEST['a_email']);
		if (isset($_REQUEST['a_group'])) {
			$user->setGroup($_REQUEST['a_group']);
		} else {
			$user->setGroup(2);
		}
		if (isset($_REQUEST['a_status'])) {
			$user->setActiveStatus($_REQUEST['a_status']);
		} else {
			$user->setActiveStatus(1);
		}
		$notification = &$this->dispatcher->post($user, 'onSave');

		$this->setupMainList();
		$this->template = 'admin/user_table.tpl';
	}
}

class PermHandler {
	function __construct() {
		// $this->exists = new Query ("select count(*) from permissions where `class`=? and `key`=? limit 1", 'ss');
		$this->getQ = new Query ("select id from permissions where `group_id`=? and `class`=? and `key`=? limit 1", 'iss');
	}

	function getPerm($group, $class, $key) {
		$p = $this->getQ->fetch($group, $class, $key);
		if ($p) return Permission::make($p['id']);
		$p = Permission::make();
		$o = $this->exists($class, $key);
		if (!$o) {
			trigger_error ("Attempt to get non-existent permissions");
			return null;
		}
		$o = $o[0];
		$p->setGroupId($group);
		$p->setClass($class);
		$p->setKey($key);
		$p->setStatus(0);
		$p->setName($o->getName());
		$p->setDescription($o->getDescription());
		return $p;
	}
	function exists($class, $key) {
		return Permission::hasPerm(1, $class, $key);
	}
	function hasPerm($group, $class, $key) {
		return !!Permission::hasPerm($group->getId(), $class, $key);
	}
}
