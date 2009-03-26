var updateReport = function() {
	new Ajax.PeriodicalUpdater('module_content', '/admin/Mail&section=reports', {
	  method: 'get', frequency: 3,
	  onComplete: function(transport) {
		ui.updateEvents();
		}
	});
	
	// This should get called by the onComplete method from the ajax call above, but we're waiting on an
	// upstream bug fix.
	
}

Event.observe(window,'load',updateReport);
