/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone){
	'use strict';

	app.Comments = Backbone.Collection.extend({
		model: app.Comment,
		url: '?controller=Comment&action=list',
		comparator : function(a, b) {
			return a.getId() > b.getId() ? -1 : 1;
		}
	});

}(window, Backbone));
