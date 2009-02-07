// ONLY DOES UPDATES OF CONTENT FOR tinyMCE CONTENT

function watchChunkSelect(sort, role, parent_class, parent_id) {
	var div = $('_select_text_'+sort);
	var select = div.down('select');
	var text = div.down('input');
	text.hide();
	function onChangeSelect() {
		if (select.value == '__new__') {
			text.show();
			return;
		}
		text.hide();
		var ed = tinyMCE.get('_chunk_'+sort);
		ed.setProgressState(1); // Show progress
		if (select.value == '' && parent_id == 0)
			return;
		else if (select.value == '')
		    $params = {action: 'loadChunk', parent_class: parent_class, parent: parent_id, sort: sort};
		else
			$params = {action: 'loadChunk', role: role, name: select.value};
		new Ajax.Request ('/admin/Content',
						  {method: 'post',
						   parameters: $params,
						   onSuccess: function (t) {
								  ed.setContent(t.responseText);
								  ed.save();
								  ed.setProgressState(0);
							  }.bind(this),
						   onFailure: function(){
								  alert('Failed to locate existing content; sorry.');
								  ed.setProgressState(0);
							  }.bind(this)
						  });
	}
	select.observe('change', onChangeSelect.bind(this));
}
