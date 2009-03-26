<?php
  /**
   * Mail Module
   * @author Christopher Troup <chris@norex.ca>
   * @package Modules
   * @version 2.0
   */

  /**
   * Training module.
   * 
   * This is essentially an example to learn how to write modules for the new CMS
   * system. It contains the bare minumum code to qualify for inclusion. This is a
   * good place to copy structure from when creating a new custom module.
   * @package Modules
   * @subpackage Mail
   */
class Module_Mail extends Module {
	
	const SEND_PER_CRON_JOB = 60;

	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	function getAdminInterface() {

		switch (@$_REQUEST['section']) {
		case 'lists':
			switch (@$_REQUEST['action']) {
			case 'updateList':
				$list = new MailList($_REQUEST['listId']);
				$form = $list->getListUsersForm();
						
				return;
				break;
			case 'delete':
				$list = new MailList(@$_REQUEST['maillist_id']);
				$list->delete();
				break;
			case 'addedit':
				$list = new MailList(@$_REQUEST['maillist_id']);
				$form = $list->getAddEditForm();
						
				if (!$form->validate() || !$form->isSubmitted() || !isset($_REQUEST['maillist_submit'])) {
					return $form->display();
				}
						
				break;
			}
			$this->addJS('/modules/Mail/js/list_edit.js');
				
			$lists = MailList::getAllMailLists();
			$this->smarty->assign('lists', $lists);
				
			return $this->smarty->fetch('admin/lists.tpl');
		case 'users':
			switch (@$_REQUEST['action']) {
			case 'addedit':
				$user = new MailUser(@$_REQUEST['mailuser_id']);
				$form = $user->getAddEditForm();
						
				if (!$form->validate() || !$form->isSubmitted() || !isset($_REQUEST['mailuser_submit'])) {
					return $form->display();
				}
				break;
			case 'delete':
				$user = new MailUser(@$_REQUEST['mailuser_id']);
				$user->delete();
						
				break;
			}
			$users = MailUser::getAllMailUsers();
			$this->smarty->assign('users', $users);
				
			return $this->smarty->fetch('admin/users.tpl');
		case 'content':
		default:
			$this->addCSS('/modules/Mail/css/send.css');
				
			switch (@$_REQUEST['action']) {
			case 'delete':
				$content = new MailContent(@$_REQUEST['mailcontent_mail_id']);
				$content->delete();
						
				break;
			case 'addedit':
				$content = new MailContent(@$_REQUEST['mailcontent_mail_id']);
						
				$form = $content->getAddEditForm();
						
				if (!$form->validate() || !$form->isSubmitted() || !isset($_REQUEST['mailcontent_submit'])) {
					return $form->display();
				} else {
					break;
				}
			case 'send':
				$lists = MailList::getAllMailLists();
						
				$content = new MailContent(@$_REQUEST['mailcontent_mail_id']);
				$this->smarty->assign('content', $content);
				$this->smarty->assign('lists', $lists);
						 
				return $this->smarty->fetch('admin/send.tpl');
				break;
			case 'queue':
				$list = new MailList($_REQUEST['maillist_id']);
				$content = new MailContent($_REQUEST['mailcontent_id']);
				$sendout = new MailSendOut();
				$sendout->accept($content);
				$sendout->setTimestamp(date('Y-m-d H:i:s'));
				$sendout->setListCount($list->getListCount());
				$sendout->save();
						
				$list->queueUsers($sendout);
						
				break;
			case 'iframe_preview':
				$content = new MailContent(@$_REQUEST['mailcontent_mail_id']);
				$this->smarty->assign('content', $content);
				$this->smarty->assign('site', SiteConfig::get('serverName'));
				echo $this->smarty->fetch('admin/shell.tpl');
				die();
				break;
			}
			$contents = MailContent::getAllMailContents("");
			$this->smarty->assign('contents', $contents);
					
			return $this->smarty->fetch( 'admin/contents.tpl' );
		case 'reports':
			switch (@$_REQUEST['action']) {
			case 'view':
				$report = new MailReport($_REQUEST['rid']);
						
				$this->smarty->assign('report', $report);
				return $this->smarty->fetch('admin/report_detail.tpl');
				break;
			default:
				break;
			}
				
			$this->addCSS('/modules/Mail/css/report.css');
			$this->addJS('/modules/Mail/js/report.js');
				
			$reports = MailReport::getAllReports();
			$this->smarty->assign('reports', $reports);
				
			return $this->smarty->fetch('admin/reports.tpl');
			break;
			
		}
	}
	
	

	public function cron() {
		require_once(dirname(__FILE__) . '/../../core/PEAR/Mail.php');
		require('Mail/mime.php');

		$queue = MailQueue::getAllMailQueues(self::SEND_PER_CRON_JOB);
		$this->smarty->assign('site', SiteConfig::get('serverName'));

		foreach ($queue as $q) {
			$content = new MailSendOut($q->getSendOut());
			$user = new MailUser($q->getUser());
				
			$crlf = "\n";
			$hdrs = array(
				'From'    => $content->getFromName() . '<' . $content->getFromAddress() . '>',
				'Subject' => $content->getSubject(),
				'To' 		=> $user->getFirstName() . ' ' . $user->getLastName() . '<' . $user->getEmail() . '>',
				'Date'	=> date('r', strtotime($content->getTimestamp()))
				);
			 
				
			$this->smarty->assign('content', $content);
			$this->smarty->assign('user', $user);
			$this->smarty->assign('site', SiteConfig::get('serverName'));
			$this->smarty->assign('unsub', SiteConfig::get('serverName') . '/mail/unsubscribe/' . $this->encode($user));
			$body = $this->smarty->fetch('admin/shell.tpl');
				
			$mime = new Mail_mime($crlf);
				
			$mime->setHTMLBody($body);
				
			//do not ever try to call these lines in reverse order
			$body = $mime->get();
			$hdrs = $mime->headers($hdrs);
				
			$mail =& Mail::factory('sendmail');
			$mail->send($user->getEmail(), $hdrs, $body);
			
			$log = new MailDeliveryLog();
			$log->setUser($user->getId());
			$log->setSendOut($content->getId());
			$log->setQueue($q->getId());
			$log->save();
				
			$q->delete();
		}
	}

	private function encode($user) {
		$id = is_object ($user) ? $user->getId() : $user;
		$rand = "mzu7FXPn";
		return "$id-" . sha1("$id$rand");
	}

	private function user() {
		$id = $_REQUEST['user'];
		$sha1 = $_REQUEST['sha'];
		return ("$id-$sha1" == $this->encode($id)) ? $id : null;
	}
	
	public function getUserInterface($params) {
		$this->parentSmarty->templateOverride = 'db:site_buttons.tpl';
		
		switch (@$_REQUEST['section']) {
		case 'collect':
			// collect client data
			$browser = $_SERVER['HTTP_USER_AGENT'];
				
			$log = new MailViewLog();
			$log->setUser($params['user']);
			$log->setSendOut($params['mso_id']);
			$log->setBrowser($browser);
			$log->save();
				
			$im = imagecreatefromjpeg(dirname(__FILE__) . '/images/norexLink.jpg');
			header("Content-Type: image/jpeg");
			imagejpeg($im);
			die();
			//params['user'] . '/' . $params['mso_id'];
		case 'signup':
			if(@!is_null($_REQUEST['newsletter_email']) || @!is_null($_REQUEST['infocollect_email'])){
				$i = DBRow::make(null,'InfoCollect');
				$i->set('email', isset($_REQUEST['newsletter_email']) ? $_REQUEST['newsletter_email'] : $_REQUEST['infocollect_email']);
				$form = $i->getAddEditForm('/mail/signup');
					
				if (!$form->isProcessed()) {
					$pageid = ContentPage::keytoid('keep-in-touch');
					$revid = ContentPage::activeRev($pageid['id']);
					$rev = ContentPageRevision::make($revid['id']);
					$this->smarty->assign('content', $rev);
					$this->setPageTitle($rev->get('page_title'));
					$page = ContentPage::make($pageid['id']);
					$this->parentSmarty->templateOverride = 'db:' . $page->get('page_template');
					return '<h1>' . $rev->get('page_title') . '</h1>' . $rev->get('content') . $form->display();
				}
					
				include_once('include/MailUser.php');
				//trim($_REQUEST['newsletter_name']);
				//$name = explode(" ", $_REQUEST['newsletter_name']);
				$nUser = new MailUser();
				$nUser->setEmail($_REQUEST['infocollect_email']);
				$nUser->setFirstName($_REQUEST['infocollect_first_name']);
				$nUser->setLastName($_REQUEST['infocollect_last_name']);
				$nUser->save();
					
				$match = array('address' => $_REQUEST['infocollect_street_address'] . ', ' . $_REQUEST['infocollect_city'],
							   'first_name' => $_REQUEST['infocollect_first_name'], 'last_name' => $_REQUEST['infocollect_last_name']);
					
				$id = Contact::matchContact($match);
				if (!$id) {
					$h = DBRow::make(null, 'Household');
					$h->set('street_address', $_REQUEST['infocollect_street_address']);
					$h->set('city', $_REQUEST['infocollect_city']);
					$h->set('postal_code', $_REQUEST['infocollect_postal_code']);
					$h->set('state', 7);
					$h->set('country', 31);
					$h->save();
						
					$c = DBRow::make(null, 'Contact');
					$c->set('contact', 1);
					$c->set('first_name', $_REQUEST['infocollect_first_name']);
					$c->set('last_name', $_REQUEST['infocollect_last_name']);
					$c->set('phone', $_REQUEST['infocollect_phone']);
					$c->set('address_id', $h->get('id'));
					$c->set('email', $_REQUEST['infocollect_email']);
					$c->save();
				} else {
					$c = DBRow::make($id, 'Contact');
					$c->set('contact', 1);
					$c->save();
				}
					
				return $this->smarty->fetch('newslettersignedup.tpl');
			}
			break;
		case 'unsubscribe':
			$id = $this->user();
			if (!$id) return;
			$lists = MailList::getAllMailLists();
			$user = new MailUser($id);
			
			foreach ($lists as $list) {
				$list->removeListUser($user->getId());
			}
				
			return 'You have been unsubscribed from all mailing lists';
		}
	}
}
