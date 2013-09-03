/*jslint browser: true*/
/*global jQuery, Backbone*/

(function($, app, Backbone) {
	'use strict';

	app.MainRouter = Backbone.Router.extend({
		lastView: null,
		app: null,

		initialize: function(options) {
			this.app = options.app;
		},

		routes: {
			"blog/view/:id": "blog_view",
			"blog/list": "blog_list",
			"": "index"
		},

		index: function() {
			console.log('index');
			this.app.onIndex();
		},

		blog_view: function(id) {
			console.log('blog_view', id);
			this.app.onBlogView(id);
		},

		blog_list: function() {
			console.log('blog_list');
			this.app.onIndex();
		}

	});

}(jQuery, window, Backbone));
