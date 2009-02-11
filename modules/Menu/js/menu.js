var menuitems = function(type) {
	new Ajax.Request('/admin/Menu', {
		method: 'post',
		parameters: { section: 'menuitem', action: 'linkables', module: $F(type) },
		onCreate: function(transport) {
			
			var menu = $('menuitem_link');
			
			var contain = menu.up();
			
			for( var key in menu.options ) {
				//menu.options[key] = null;
				menu.remove(key);
			}
			
			menu.disable();
			
			if(contain.lastChild != '[object Text]'){
				contain.insert('&nbsp;');
			}
		},
		onSuccess: function(transport) {
			var menu = $('menuitem_link');
			
			var opts = transport.responseText.evalJSON();
			
			menu.enable();

			var i = 0;
			opts.each(function(el) {
				var opt = new Option(el.value, el.key);
				menu.options[i] = opt;
				i++;
			});
		}
	});
}

Event.observe(window, 'load', function() {
	if ($('MenuItem_addedit')) {
		Event.observe($('menuitem_module'), 'change', menuitems);
	}
});
