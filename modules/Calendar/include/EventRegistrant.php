<?php

class EventRegistrant extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('CalendarEvent(event_name)', 'event_id', 'Event'),
			DBColumn::make('!text', 'first_name', 'First Name'),
			DBColumn::make('!text', 'last_name', 'Last Name'),
			DBColumn::make('!email', 'email', 'Email Address'),
			DBColumn::make('!text', 'phone', 'Phone Number'),
			DBColumn::make('status', 'status', 'Paid'),
			);
		return parent::createTable("calendar_registrants", __CLASS__, $cols);
	}
	static function make($id = null) {return parent::make($id, __CLASS__);}
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
	
	function quickformPrefix() {return 'calendar_registrants_';}
}
DBRow::init('EventRegistrant');

