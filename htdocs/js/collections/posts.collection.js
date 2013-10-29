/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone){
	'use strict';

	app.Posts = Backbone.Collection.extend({
		model: app.Post,
		url: '?controller=Post&action=list'
	});

}(window, Backbone));
