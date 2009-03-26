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

