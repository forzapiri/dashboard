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

// ONLY DOES UPDATES OF CONTENT FOR tinyMCE CONTENT

function watchChunkSelect(sort, role, parent_class, parent_id, n, i) { // We are in chunk i out of n
	var div = $('_select_text_'+sort);
	var select = div.down('select');
	var prev = $('_chunk_prev_'+sort);
	var next = $('_chunk_next_'+sort);
	var text = div.down('input');
	var rev = i;
	if (text) {
		text.hide();
		checkArrows(i, n);
	}
	select.observe('change', onChange.bind(this));
	if (text) {
		prev.observe('click', onChange.bind(this));
		next.observe('click', onChange.bind(this));
	}
	function checkArrows(i, n) {
		rev = i;
		if (i > 1) prev.show(); else prev.hide();
		if (i < n) next.show(); else next.hide();
	}
	function onChange(event) {
		if (text && select.value == '__new__') {
			text.show();
			prev.hide();
			next.hide();
			return;
		}
		if (text) {
			text.hide();
			var ed = tinyMCE.get('_chunk_'+sort);
			var input = $('_chunk_'+sort);
			if (typeof(ed) == 'undefined') ed = false;
			if (ed) ed.setProgressState(1); // Show progress
		}
		if (select.value == '' && parent_id == 0)
			return;
		var i=0; // Meaning latest version
		if (event.element() == prev) {i = rev-1;}
		if (event.element() == next) {i = rev+1;}
		if (select.value == '')
		    $params = {action: 'chunk_load', section: parent_class, id: parent_id, sort: sort, i: i};
		else
			$params = {action: 'chunk_load', role: role, name: select.value, i: i};
		new Ajax.Request ('/admin/Content',
						  {method: 'post',
						   parameters: $params,
						   onSuccess: function (t) {
								  var result = t.responseText.evalJSON(true);
								  var content = result.content ? result.content : '';
								  if (ed) {
									  ed.setContent(content);
									  ed.save();
									  ed.setProgressState(0);
								  } else {
									  input.update(content);
								  }
								  checkArrows(result.i, result.n);
							  }.bind(this),
						   onFailure: function(){
								  alert('Failed to locate existing content; sorry.');
								  if (ed) ed.setProgressState(0);
							  }.bind(this)
						  });
	}
}
