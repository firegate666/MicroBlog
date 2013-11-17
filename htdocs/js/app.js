/*jslint browser: true*/
/*global jQuery*/

(function($, app, us) {
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

			$('#app').empty().append(currentView.el);
		};

		/**
		 * handle book new dialog
		 */
		this.onBlogView = function(id_arg) {
			var id = parseInt(id_arg, 10),
				blog = app.blogs.findWhere({id: id}),
				posts = new Backbone.Collection(app.posts.where({blog_id : id})),
				comments = app.comments;

			if (currentView) {
				currentView.remove();
				currentView = null;
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

}(jQuery, window, _));
