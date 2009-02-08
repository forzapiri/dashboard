// ONLY DOES UPDATES OF CONTENT FOR tinyMCE CONTENT

function watchChunkSelect(sort, role, parent_class, parent_id, n, i) { // We are in chunk i out of n
	var div = $('_select_text_'+sort);
	var select = div.down('select');
	var prev = $('_chunk_prev_'+sort);
	var next = $('_chunk_next_'+sort);
	var text = div.down('input');
	var rev = i;
	text.hide();
	checkArrows(i, n);
	select.observe('change', onChange.bind(this));
	prev.observe('click', onChange.bind(this));
	next.observe('click', onChange.bind(this));
	function checkArrows(i, n) {
		rev = i;
		if (i > 1) prev.show(); else prev.hide();
		if (i < n) next.show(); else next.hide();
	}
	function onChange(event) {
		if (select.value == '__new__') {
			text.show();
			prev.hide();
			next.hide();
			return;
		}
		text.hide();
		var ed = tinyMCE.get('_chunk_'+sort);
		ed.setProgressState(1); // Show progress
		if (select.value == '' && parent_id == 0)
			return;
		var i=0; // Meaning latest version
		if (event.element() == prev) {i = rev-1;}
		if (event.element() == next) {i = rev+1;}
		if (select.value == '')
		    $params = {action: 'chunk_load', parent_class: parent_class, parent: parent_id, sort: sort, i: i};
		else
			$params = {action: 'chunk_load', role: role, name: select.value, i: i};
		new Ajax.Request ('/admin/Content',
						  {method: 'post',
						   parameters: $params,
						   onSuccess: function (t) {
								  var result = t.responseText.evalJSON(true);
								  ed.setContent(result.content);
								  ed.save();
								  ed.setProgressState(0);
								  checkArrows(result.i, result.n);
							  }.bind(this),
						   onFailure: function(){
								  alert('Failed to locate existing content; sorry.');
								  ed.setProgressState(0);
							  }.bind(this)
						  });
	}
}
