<?php

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
		return new DBTable("calendar_events", __CLASS__, $cols);
	}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	function quickformPrefix() {return 'calendar_events_';}
}
DBRow::init('CalendarEvent');

?>