/*jslint browser: true*/
/*global jQuery, Backbone*/

(function($, app, Backbone){
	'use strict';

	$(function() {

		Backbone.emulateHTTP = true;
		Backbone.emulateJSON = true;

		app.TM = new app.TemplateManager();
		app.TM.addTemplates('.template', $('body'));

        var startup = function() {
            app.App = new app.MicroBlog();

            app.Router = new app.MainRouter({
                app: app.App
            });

            Backbone.history.start();
        }

        app.posts = new app.Posts();
        app.posts.fetch();

		app.comments = new app.Comments();
        app.comments.fetch();

        app.blogs = new app.Blogs();
        app.blogs.fetch({success: startup});

	});

}(jQuery, window, Backbone));