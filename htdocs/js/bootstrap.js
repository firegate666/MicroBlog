/*jslint browser: true*/
/*global jQuery, Backbone*/

(function($, app, Backbone){
	'use strict';

	$(function() {

		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;

		app.blogs = new app.Blogs();
		app.blogs.fetch();

		app.TM = new app.TemplateManager();
		app.TM.addTemplates('.template', $('body'));

		app.App = new app.MicroBlog();

		app.Router = new app.MainRouter({
			app: app.App
		});

		Backbone.history.start();

	});

}(jQuery, window, Backbone));