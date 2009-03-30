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

class CalendarEvent extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'event_name', 'Name'),
			DBColumn::make('textarea', 'event_description', 'Description'),
			DBColumn::make('datetime', 'event_start', 'Start Date'),
			DBColumn::make('datetime', 'event_end', 'Start Date'),
			DBColumn::make('text', 'event_location', 'Location'),
			DBColumn::make('Calendar(name)', 'calendar_id', 'Calendar'),
			'//status'
			);
		return parent::createTable("calendar_events", __CLASS__, $cols);
	}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function countAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}
	function quickformPrefix() {return 'calendar_events_';}
	function getAddEditFormBeforeSaveHook() {$this->setCalendarId(1);}
	function getAddEditFormHook($form) {
		$script = '<script type="text/javascript">linkStartEndTimes("calendar_events_event_start","calendar_events_event_end",false)</script>';
		$form->addElement ('html', $script);
	}
}
DBRow::init('CalendarEvent');

