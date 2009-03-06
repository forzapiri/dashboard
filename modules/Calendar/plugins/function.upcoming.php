<?php

function smarty_function_upcoming($params, &$smarty) {
	$html = '<div class="block">';
	$html .= '<h1>Upcoming <b>Events</b></h1>';
	
	$events = CalendarEvent::getAll('where event_start >= NOW() order by event_start asc limit 8');
	
	foreach ($events as $event) {
		$html .= '<div class="event">';
		$html .= '<h3><a href="/calendar/' . $event->get('id') . '-' . smarty_modifier_urlify($event->get('event_name')) . '">' . $event->get('event_name') . '</a></h3>';
		$html .= '<h6>' . date('F jS, Y', strtotime($event->get('event_start'))) . '</h6>';
		$html .= '<h6>' . $event->get('event_location') . '</h6>';
	    
	    require_once(SITE_ROOT . '/core/libs/plugins/modifier.truncate.php');
		
		$html .= '<p>' . smarty_modifier_truncate(smarty_modifier_strip_tags($event->get('event_description')));
		$html .= ' &nbsp; <a href="/calendar/' . $event->get('id') . '-' . smarty_modifier_urlify($event->get('event_name')) . '">read more</a></p>';
		$html .= '</div>';
		$html .= '<div class="hr">&nbsp;</div>';
	}
	
	$html .= '</div>';
	
	$html .= '<a href="/calendar/">View All Upcoming Events</a><br /><br />';
	
	return $html;
}

