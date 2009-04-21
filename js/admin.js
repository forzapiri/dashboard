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

// Deprecated Code --- Use
//		class="norexui_delete"
//		class="norexui_addedit"
//      rather than deleteConfirm

function deleteConfirm(form) {
	if (confirm("Delete?")) {
		new Effect.Fade(form.up('tr'), {
			duration: 0.5
		});
		return $(form).request();
	}
	return true;
}

////////////////////////////////////////////////
var Message = Class.create({
  type: 'success',
  message: '',
  delay: 8,

  classnames: ['success', 'error', 'warning'],
  
  initialize: function(options) {
    if (options.type) this.type = options.type;
    if (options.message) this.message = options.message;
    this._show();
  },
  
  _getClass: function() {
	  if (this.type == 'success') return this.classnames[0];
	  if (this.type == 'error') return this.classnames[1];
	  if (this.type == 'warning') return this.classnames[2];
  },
  
  _getTitle: function() {
	  if (this.type == 'success') return 'Success';
	  if (this.type == 'error') return 'Error';
	  if (this.type == 'warning') return 'Warning';
  },
  
  _show: function() {
	  var msg = Builder.node('div', {'class': this._getClass(), height: '40px'}, Builder.node('div', {}, this.message)).hide();
	  $('messages').insert({top:msg});
	  new Effect.Appear(msg, {fps: 100});
	  new Effect.Fade(msg, {duration: 1.0, delay: this.delay, 
		afterFinish: function() {
		  msg.remove();
	  	}
	  });
  }
});

var NorexUI = Class.create(Facebox, {
	
	initialize: function($super) {
		//$super();
		this.updateEvents();
	},
	
	updateEvents: function() {
		$$('table tr.row1').invoke('observe', 'click', 
			function(event) { 
				var row = event.element().up('tr');
				new Effect.Highlight(row, {duration:1.5, startcolor: '#ffff99', endcolor: '#ffffff', restorecolor: '#ffffff'});
			}
		);
		$$('table tr.row2').invoke('observe', 'click', 
			function(event) { 
				var row = event.element().up('tr');
				new Effect.Highlight(row, {duration:1.5, startcolor: '#ffff99', endcolor: '#f8f8f8', restorecolor: '#f8f8f8'});
			}
		);
		
		$$('div#left_menu ul li div.handle').invoke('observe', 'click', 
				function(event) {
					var el = Event.element(event);
					Effect.Appear(el.next('ul'));
				}
		);
		
		$$('form.norexui_addedit').invoke('observe', 'submit', this.addedit);
		$$('form.norexui_delete').invoke('observe', 'submit', this.deleteConfirm);
		$$('li.norexui_delete').invoke('observe', 'click', this.deleteConfirm);
		
		$$('div#buttons ul#primary:not(ul.plain) li:not(li.plain)').invoke('observe', 'click', this.addedit);

		// To make a sortable admin list, use <tbody id="foo" class="sortable">
		// A PhP template looks like:
		// case 'sort':
		//	foreach (getSerializedRequest() as $i => $j) {
		//		$item = new Foo($j);
		//		$item->setSort($i);
		//		$item->save();
		//	}
		
		$$('tbody.sortable').each(function (e) {
				id = e.identify();
				Sortable.create(id, {
					tag: 'tr',
					onUpdate: function() {
						new Ajax.Request (window.location, {
							method: "post",
							parameters: { action: 'sort', data: Sortable.serialize(id) },
							onComplete: function(transport) {
								ui.updateContent(transport.responseText);
							}
						});
					}
				});
			}
		);
	},
	
	addedit: function(event) {
		var form = Event.element(event);
		if (form.href) {
			window.location.hash = form.href;
			form = Builder.node('form', {action: form.href, method: 'post'});
		} else {
			window.location.hash = $(form).serialize();
		}
		var r = $(form).request({
			onSuccess: function(transport) {
				ui.loading();
				ui.reveal(transport.responseText);
				ui.updateEvents();
				if (form = $('facebox').down('form')) {
					Event.observe(form, 'submit', function(event) {
				  		ui.formSubmit(form);
				  		event.stop();
				 	});
			 	}
			}
		});
		
		if (r) event.stop();
	},
	
	formSubmit: function(form) {
		window.location.hash = $(form).serialize();
		return $(form).request( {
			onSuccess: function(transport) {
				if (transport.responseText.match(/class="error/)) {
					var displaybox = $$('div#facebox div.content')[0];
					displaybox.update(transport.responseText); 
					var form = displaybox.down('form');
					$(form).observe('submit', function(event){
				  		ui.formSubmit(form);
				  		Event.stop(event);
				 	});
				} else {
					ui.updateContent(transport.responseText);
				}
			},
			onComplete: function(transport) {
				if (!transport.responseText.match(/class="error/)) {
					//new Message({message: 'Item was updated successfully'});
					
					ui.close();
				} else {
					//new Message({type: 'error', message: 'Not all fields were filled in'});
				}
			}
		});
	},
	createDone: function(item) {
		result=document.getElementById('filetarget').contentDocument.body.innerHTML;
		val = result.evalJSON();
			var all = val.all;
			
			var menu = $(item);
			
			for( var key in menu.options ) {
				menu.options[key] = null;
				menu.remove(key);
			}
			
			var i = 2;
			var inserted = 0;
			menu.appendChild(new Option('-- NONE --', 0));
			menu.appendChild(new Option('-- Create New --', 'new'));
			all.each(function(el) {
				var opt = new Option(el.value, el.key);
				if (el.key == val.created) {
					inserted = i;
					opt.selected = true;
				}
				menu.appendChild(opt);
				i++;
			});
			ui.close();
	},
	
	createHandler: function(item, type) {
		if ($F(item) != 'new') return;
		new Ajax.Request('/admin/DMS', {
			method: 'post',
			parameters: { 'X-CreateClass': type },
			onSuccess: function(transport) {
				ui.loading();
				ui.reveal(transport.responseText);
				
				var displaybox = $('facebox').down('div.content'); //$$('div#facebox div.content')[0];
				var form = displaybox.down('form');
				
				if (!$('filetarget')) {
					var iframe = Builder.node('iframe', {name: 'filetarget', id: 'filetarget'});
				} else {
					var iframe = $('filetarget');
				}
				
				iframe.hide();
				displaybox.appendChild(iframe);
				form.target = iframe.name;
				
				
				$(form).observe('submit', function(event){
					iframe.onload = function() {
						setTimeout('ui.createDone("' + item.identify() + '")', 10);
					}
			 	});
			}
		});
		
	},

	updateContent: function(content) {
		$('module_content').update(content);
		$('module_content').fire('norexui:update');
		this.updateEvents.defer();
	},

	deleteConfirm: function(event) {
		el = Event.element(event);
		var message = el.title ? el.title : "Are you sure you want to delete this? Deleting it will also remove all sub-items";
		event.stop(event);
		elFade = el.tagName == 'FORM' ? el.up('tr') : el;
		if (confirm(message)) {
			new Effect.Fade(elFade, {
				duration: 0.5
			});
			args = {onComplete: function(transport) {ui.updateContent(transport.responseText);}};
			switch (el.tagName) {
			case 'FORM': return el.request(args);
			case 'A': return new Ajax.Request(el.href, {});
			}
		} else {
			event.stop(event);
		}
	},

	clearcaches: function() {
			new Ajax.Request("/buildtools/install/clearcaches.php", {});
			return false;
		}
});

var ui;
Event.observe(window, 'load', function(e) {
	ui = new NorexUI();
	});

var myCustomOnChangeHandler = function(inst) {
	$(inst.id).value = inst.getBody().innerHTML;
}

function initRTE(mode, theme, name, stylesheet, bodyId, bodyClass) {
	tinyMCE.init({
		mode : mode,
		theme : theme,
		elements : name,
		plugins : "safari,spellchecker,style,advimage,advlink,iespell,inlinepopups,contextmenu,paste",
		theme_advanced_buttons1_add : "forecolor,backcolor",
		theme_advanced_buttons1_add_before: "cut,copy,paste,pastetext,pasteword",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		dialog_type : "modal",
		relative_urls : false,
		button_tile_map : true,
		theme_advanced_statusbar_location : "bottom",
		content_css : stylesheet,
	    plugin_insertdate_dateFormat : "%Y-%m-%d",
	    body_id : bodyId,
	    onchange_callback : "myCustomOnChangeHandler",
	    body_class : bodyClass,
	    plugin_insertdate_timeFormat : "%H:%M:%S",
		file_browser_callback : "norexFileBrowser",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
		apply_source_formatting : true,
		spellchecker_languages : "+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv",
		oninit: "resizeFacebox",
		width: "450"
	});
	
	
	return;
}

function resizeFacebox() {
	if ($('facebox')) {
		var pageScroll = document.viewport.getScrollOffsets();
		$('facebox').setStyle({
			'top': pageScroll.top + (document.viewport.getHeight() / 8) + 'px',
			'left': pageScroll.left + ((document.viewport.getWidth() - $('facebox').getWidth()) / 2) + 'px'
		});
	}
}

function norexFileBrowser (field_name, url, type, win) {

    // alert("Field_Name: " + field_name + "\nURL: " + url + "\nType: " + type + "\nWin: " + win); // debug/testing

    /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
       the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
       These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

    var cmsURL = '/core/DataStorage.php?browser=true';    // script URL - use an absolute path!
    if (cmsURL.indexOf("?") < 0) {
        //add the type as the only query parameter
        cmsURL = cmsURL + "&type=" + type;
    }
    else {
        //add the type as an additional query parameter
        // (PHP session ID is now included if there is one at all)
        cmsURL = cmsURL + "&type=" + type;
    }

    tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Norex File Browser',
        width : 500,  // Your dimensions may differ - toy around with them!
        height : 500,
        resizable : "yes",
        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;
  }

var thickboxAddEdit = function(element) {
	if (!element.nodeType) {
		Event.stop(element);
		// Element is bound event listener to an <a href> link
		return new Ajax.Request(Event.element(element).href, {
			method: 'get',
			onSuccess: function(transport) {
				showThickBox(transport);
			}, 
			onComplete: function(transport) {
				
			}
		});
	} else {
		// Element is DOM form object
		return $(element).request({
			onSuccess: function(transport) {
				showThickBox(transport);
			}
		});
	}
}