/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone){
	'use strict';

	app.Posts = Backbone.Collection.extend({
		model: app.Post,
		url: '?controller=Post&action=list',
		comparator : function(a, b) {
			return a.getId() > b.getId() ? -1 : 1;
		}
	});

}(window, Backbone));
