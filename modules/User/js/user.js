var user_check = function(event) {
	var element = Event.element(event);
	new Ajax.Request('/user/details_check', {
		method: "post",
		parameters: { username: $F(element) },
		onComplete: function(transport) {
			if ($('user_message')) {
				$('user_message').remove();
			}
			if (transport.responseText == 'true') {
				var msg = Builder.node('div', {id: 'user_message'}, 'That username is already in use');
				$('user_username').insert({after: msg});
				$('user_submit').disable();
			} else {
				$('user_submit').enable();
			}
		}
	});
	
}

var pass_check = function(event) {
	var element = Event.element(event);
	if ($('user_message_pass')) {
		$('user_message_pass').remove();
	}
	if ($F(element).length <= 5) {
		var msg = Builder.node('div', {id: 'user_message_pass'}, 'That password is too short. Passwords must be at least 6 characters');
		$('user_password').insert({after: msg});	
		$('user_submit').disable();
	} else {
		$('user_submit').enable();
	}
}

Event.observe(window, 'load', function() {
	if ($('user_username')) {
		$('user_username').observe('change', user_check);
	}
	if ($('user_password')) {
		$('user_password').observe('change', pass_check);
	}
});