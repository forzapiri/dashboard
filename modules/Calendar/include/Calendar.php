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

class Calendar extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Name'),
			);
		return parent::createTable("calendar", __CLASS__, $cols);
	}
	public static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	static function countAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getCountRows'), $args);
	}
	function quickformPrefix() {return 'calendar_';}
	
	public function getAllCalendarEvents($calendar, $year, $month) {
		$calendar = (integer) $calendar;
		$restrict = $calendar ? 'calendar_id=?' : '0=?';
		return CalendarEvent::getAll("where event_start >=? and event_end <? and $restrict order by event_start", 'ssi', 
									 $year . '-' . $month . '-01',
									 $year . '-' . ($month + 1) . '-01',
									 $calendar);
	}
	
	public function getLink() {
		require_once(SITE_ROOT . '/core/plugins/modifier.urlify.php');
		$link = '/calendar/' . $this->get('id') . '/';
		return '<a href="' . $link . '">' . $link . '</a>';
	}
}
DBRow::init('Calendar');

