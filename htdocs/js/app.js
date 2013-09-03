/*jslint browser: true*/
/*global jQuery*/

(function($, app) {
	'use strict';

	app.MicroBlog = function() {

		/**
		 * store current view
		 */
		var currentView = null;

		/**
		 * handle switch to homescreen
		 */
		this.onIndex = function() {
			if (currentView) {
				currentView.remove();
				currentView = null;
			}

			currentView = new app.BlogsView({
				collection: app.blogs
			});

			$('#app').empty();
			$('#app').append(currentView.el);
		};

		/**
		 * handle book new dialog
		 */
		this.onBlogView = function(id_arg) {
			var id = parseInt(id_arg, 10);
			if (currentView) {
				currentView.remove();
				currentView = null;
			}

			currentView = new app.BlogView({
				model: app.blogs.where({id: id})[0]
			});

			$('#app').empty();
			$('#app').append(currentView.el);
		};

	};

}(jQuery, window));
