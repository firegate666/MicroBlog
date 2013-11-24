/*jslint browser: true*/
/*global jQuery*/

(function($, app) {
	'use strict';

	app.MicroBlog = function() {

		/**
		 * store current view
		 *
		 * @property {Backbone.View}
		 */
		var currentView = null;

		/**
		 * handle switch to homescreen
		 *
		 * @returns {void}
		 */
		this.onIndex = function() {
			if (currentView) {
				currentView.remove();
			}

			currentView = new app.BlogsView({
				collection: app.blogs
			});

			$('#app').empty().append(currentView.el);
		};

		/**
		 * handle show blog
		 *
		 * @returns {void}
		 */
		this.onBlogView = function(id_arg) {
			var id = parseInt(id_arg, 10),
				blog = app.blogs.findWhere({id: id}),
				posts = app.posts,
				comments = app.comments;

			if (currentView) {
				currentView.remove();
			}

			currentView = new app.BlogView({
				model : blog,
                collection: {
					posts : posts,
					comments : comments
				}
			});

			$('#app').empty().append(currentView.el);
		};

	};

}(jQuery, window));
