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