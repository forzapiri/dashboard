(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('showhide');

	tinymce.create('tinymce.plugins.ShowHide', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			var t = this, tbId = ed.getParam('dashboard_adv_toolbar', 'toolbar2'), last = 0, moreHTML, nextpageHTML;
			ed.settings.dashboard_adv_hidden = 1;

			// Hides the specified toolbar and resizes the iframe
			ed.onPostRender.add(function() {
				if ( ed.getParam('dashboard_adv_hidden', 1) ) {
					tinymce.DOM.hide(ed.controlManager.get(tbId).id);
					//t._resizeIframe(ed, tbId, 28);
				}
			});
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceShowHide', function() {
				var id = ed.controlManager.get(tbId).id, cm = ed.controlManager;
				if (tinymce.DOM.isHidden(id)) {
					cm.setActive('wp_adv', 1);
					tinymce.DOM.show(id);
					//t._resizeIframe(ed, tbId, -28);
					ed.settings.dashboard_adv_hidden = 0;
				} else {
					cm.setActive('wp_adv', 0);
					tinymce.DOM.hide(id);
					//t._resizeIframe(ed, tbId, 28);
					ed.settings.dashboard_adv_hidden = 1;
				}
			});

			// Register example button
			ed.addButton('showhide', {
				title : 'showhide.desc',
				cmd : 'mceShowHide',
				image : url + '/img/toolbars.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('showhide', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'ShowHide plugin',
				author : 'Chris Troup',
				authorurl : 'http://www.dashboardwebapp.com',
				infourl : 'http://www.dashboardwebapp.com',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('showhide', tinymce.plugins.ShowHide);
})();
