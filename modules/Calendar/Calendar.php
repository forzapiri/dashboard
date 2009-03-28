<?php
/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

class Module_Calendar extends Module {
	
	public $icon = '/modules/Calendar/images/calendar.png';
	
	public function __construct() {
		$this->page = new Page();
		$this->page->with('Calendar')
			 ->show(array(
			 	'Name' => 'name',
			 	'Link' => array('id', array('Calendar', 'getLink'))
			 ))
			 ->on('addedit')->action('CalendarEvent')->noAJAX()
			 ->name('Calendar');
			 
		$this->page->with('CalendarEvent')
			 ->show(array(
			 	'Event Name' => 'event_name',
			 	'Event Start' => 'event_start',
			 	'Event End' => 'event_end',
			 ))
			 ->link(array('calendar_id', array('Calendar', 'id')))
			 ->on('addedit')->action('EventRegistrant')->noAJAX()
			 ->name('Calendar Event');
			 
		$this->page->with('EventRegistrant')
			 ->show(array(
			 	'First Name' => 'first_name',
			 	'Last Name' => 'last_name',
			 	'Email Address' => 'email',
			 	'Phone Number' => 'phone',
			 	'Paid' => 'status',
			 ))
			 ->name('Event Registrant')
			 ->link(array('event_id', array('CalendarEvent', 'id')));
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
		$this->addJS('/js/linkDates.js');
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
		$linkItems = Database::singleton()->query_fetch_all('select * from calendar');
		foreach($linkItems as $linkItem){
			$linkables[$linkItem['id']] = $linkItem['name'];
		}
		return $linkables;
	}
	
	public function getLinkable($id){
		return '/calendar/' . $id . '/';
	}
}
