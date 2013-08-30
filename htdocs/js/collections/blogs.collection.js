/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone){
	'use strict';

	app.Blogs = Backbone.Collection.extend({
		model: app.Blog,
		url: '?controller=Blog&action=list'
	});

}(window, Backbone));
