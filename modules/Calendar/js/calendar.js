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

var doUpdate = function() {
	var days = $$('table.calendar td.active');
	days.each(function(e) {
		Event.observe(e, 'click', newEvent.bindAsEventListener(e));
	});
	
	var events = $$('table.calendar td.active div.event');
	events.each(function(e) {
		Event.observe(e, 'click', editEvent.bindAsEventListener(e));
	});
}

var newEvent = function(event) {
	var element = Event.element(event);
	if (element.up('td')) {
		element = element.up('td');
	}
	
	Event.stop(event);
	
	return new Ajax.Request('/calendar/', {
			method: 'post',
			parameters: { section: 'addedit', date: element.identify() },
			onComplete: function(transport) {
				facebox.loading();
				facebox.reveal(transport.responseText);
				new Effect.Appear($('facebox'), {duration: 0.2, fps: 100});
				
				if (form = $('facebox').down('form')) {
					Event.observe(form, 'submit', function(event) {
				  		formSubmit(form);
				  		Event.stop(event);
				 	});
			 	}
			}
	});
	
}

var editEvent = function(event) {
	var element = Event.element(event);
	
	Event.stop(event);

	return new Ajax.Request('/calendar/', {
			method: 'post',
			parameters: { section: 'addedit', calendarevent_event_id: element.identify() },
			onComplete: function(transport) {
				facebox.loading();
				facebox.reveal(transport.responseText);
				new Effect.Appear($('facebox'), {duration: 0.2, fps: 100});
				
				if (form = $('facebox').down('form')) {
					Event.observe(form, 'submit', function(event) {
				  		formSubmit(form);
				  		Event.stop(event);
				 	});
			 	}
			}
	});
	
}

var formSubmit = function(form) {
	return $(form).request( {
		onSuccess: function(transport) {
			if (transport.responseText.match(/class="error/)) {
				var displaybox = $('facebox'); 
				displaybox.update(transport.responseText);
				var form = displaybox.down('form');
				$(form).observe('submit', function(event){
			  		formSubmit(form);
			  		Event.stop(event);
			 	});
			} else {
				updateModuleContent(transport.responseText);
			}
		},
		onComplete: function(transport) {
			if (!transport.responseText.match(/class="error/)) {
				new Effect.Fade($('facebox'), {duration: 0.2, fps: 100});
			}
		}
	});
	
	return true;
}

var updateModuleContent = function(moduleContent) {
	$('leftCol').update(moduleContent);
	doUpdate();
}

Event.observe(window, 'load', doUpdate);