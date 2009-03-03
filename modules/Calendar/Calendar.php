<?php
/**
 * Skeleton Module
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
 * @subpackage Skeleton
 */
class Module_Calendar extends Module {
	
	public function __construct() {
		$this->page = new Page();
		$this->page->with('Calendar')
			 ->show(array(
			 	'Name' => 'name',
			 	'Link' => array('id', array('Calendar', 'getLink'))
			 ))
			 ->on('addedit')->action('CalendarEvent')
			 ->name('Calendar');
			 
		$this->page->with('CalendarEvent')
			 ->show(array(
			 	'Event Name' => 'event_name',
			 	'Event Start' => 'event_start',
			 	'Event End' => 'event_end',
			 	//'Show in Sidebar' => 'status'
			 ))
			 ->link(array('calendar_id', array('Calendar', 'id')))
			 ->name('Calendar Event');
			 
		$this->page->with('Calendar');
	}
	
	/**
	 * Build and return admin interface
	 * 
	 * Any module providing an admin interface is required to have this function, which
	 * returns a string containing the (x)html of it's admin interface.
	 * @return string
	 */
	public function getAdminInterface() {
		return $this->page->render();
	}

	
	public function getUserInterface($params) {
			/*
		if (isset($_REQUEST['calendar_id'])) {
			$calendar = DBRow::make($_REQUEST['calendar_id'],'Calendar');
		
			$events = CalendarEvent::getAll('where event_start >="' . date('Y-m-d') . '" and calendar_id=' . $calendar->get('id') . ' order by event_start asc');
			$this->smarty->assign('events', $events);		
			$this->smarty->assign('calendar', $calendar);
			return $this->smarty->fetch('calendarevents.htpl');
		} else if (isset($_REQUEST['event'])) {
			$event = DBRow::make($_REQUEST['event'], 'CalendarEvent');
			$this->smarty->assign('event', $event);
			return $this->smarty->fetch('event.tpl');
		} else {
			$events = CalendarEvent::getAll('where event_start >="' . date('Y-m-d') . '" order by event_start asc');
			$this->smarty->assign('events', $events);		
			return $this->smarty->fetch('allevents.htpl');
		}*/
		$this->setPageTitle('Calendar');
		$this->addCSS('/modules/Calendar/css/calendar.css');
		
		if (empty($_GET['year']) || empty($_GET['month']) || empty($_GET['day'])) {
		    $today = getdate();
		    $year = $today['year'];
		    $month = $today['mon'];
		    $day = $today['mday'];
		} else {
		    $year = $_GET['year'];
		    $month = $_GET['month'];
		    $day = $_GET['day'];
		}
		
		$smarty = $this->smarty;
		$smarty->assign('year', $year);
		$smarty->assign('month', $month);
		$smarty->assign('day', $day);
		$smarty->assign('url_format', '/calendar/' . $_REQUEST['calendar_id'] . '/%Y/%m/%d');
		
		if (isset($_REQUEST['event'])) {
			$event = DBRow::make($_REQUEST['event'], 'CalendarEvent');
			$this->smarty->assign('event', $event);
			return $this->smarty->fetch('event.tpl');
		}else if (isset($_REQUEST['calendar_id'])) {
			$events = Calendar::getAllCalendarEvents($_REQUEST['calendar_id'], $year, $month);
			$this->smarty->assign('calendar', $_REQUEST['calendar_id']);
		} else {
			$events = Calendar::getAllCalendarEvents(SiteConfig::get('Calendar::frontPage'), $year, $month);	
		}
		$smarty->assign('events', $events);
		
		return $smarty->fetch('view_calendar.tpl');
	}
	
	public function getUpcoming() {
		$events = Calendar::getAllCalendarEvents(SiteConfig::get('Calendar::frontPage'), $year, $month);
		return;
	}
	
	public static function getLinkables($level = 0, $id = null){
		$linkItems = Calendar::getAll();
		foreach($linkItems as $linkItem){
			$linkables[$linkItem->get('id')] = $linkItem->get('name');
		}
		return $linkables;
	}
	
	public function getLinkable($id){
		return '/calendar/' . $id . '/';
	}
}

?>