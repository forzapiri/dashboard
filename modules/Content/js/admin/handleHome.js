var removeElements = function() {
	var table = $('module_content').getElementsBySelector('[class="adminList"]')['0'].down();
	var tableElements = table.getElementsBySelector('[class="norexui_delete"]');
	for(var i = 0; i < tableElements.length; i++){
		var container = tableElements[i].up('tr').down('td');
		var name = container.firstChild.nodeValue;
		if(name == 'Home'){
			tableElements[i].hide();
		}
	}
}

Event.observe(window, 'load', function() {
	document.observe('norexui:update', removeElements);
	$('module_content').fire('norexui:update');
});