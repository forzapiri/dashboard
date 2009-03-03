<?php

class Calendar extends DBRow {
	function createTable() {
		$cols = array(
			'id?',
			DBColumn::make('text', 'name', 'Name'),
			);
		return new DBTable("calendar", __CLASS__, $cols);
	}
	static function getAll() {
		$args = func_get_args();
		array_unshift($args, __CLASS__);
		return call_user_func_array(array('DBRow', 'getAllRows'), $args);
	}
	function quickformPrefix() {return 'calendar_';}
	
	public function getAllCalendarEvents($calendar, $year, $month) {
		
		return CalendarEvent::getAll('where event_start >=? and event_end <? and calendar_id=? order by event_start', 'ssi', 
			$year . '-' . $month . '-01',
			$year . '-' . ($month + 1) . '-01',
			$calendar);
	}
	
	public function getLink() {
		require_once(SITE_ROOT . '/core/plugins/modifier.urlify.php');
		$link = '/calendar/' . $this->get('id') . '/' . smarty_modifier_urlify($this->get('name'));
		return '<a href="' . $link . '">' . $link . '</a>';
	}
}
DBRow::init('Calendar');

?>