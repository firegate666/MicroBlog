/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone){
	'use strict';

	app.Comments = Backbone.Collection.extend({
		model: app.Comment,
		url: '?controller=Comment&action=list'
	});

}(window, Backbone));
