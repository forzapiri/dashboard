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