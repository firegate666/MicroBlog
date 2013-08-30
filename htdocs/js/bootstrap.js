/*jslint browser: true*/
/*global jQuery, Backbone*/

(function($, app, Backbone){
	'use strict';

	$(function() {

		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;

		app.blogs = new app.Blogs();
		app.blogs.fetch();

		/*$.get('templates/bookshelf.templates.html', {}, function(content) {
			app.TM.addTemplates('.template', content);

			app.Router = new app.MainRouter({
				app: app.App
			});

			Backbone.history.start();
		}, 'html');*/

	});

}(jQuery, window, Backbone));