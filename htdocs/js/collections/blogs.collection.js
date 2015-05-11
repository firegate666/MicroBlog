/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone){
	'use strict';

	app.Blogs = Backbone.Collection.extend({
		model: app.Blog,
		url: '?controller=Blog&action=list',
		comparator : function(a, b) {
			return a.getTitle() > b.getTitle() ? 1 : -1;
		}
	});

}(window, Backbone));
