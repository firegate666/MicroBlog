/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone) {
	'use strict';

	app.Blog = Backbone.Model.extend({

		urlRoot : '?controller=Blog',

		url : function() {
			if (this.isNew()) {
				return this.urlRoot;
			}

			return this.urlRoot + '&id=' + this.id;
		},

		getId : function() {
			return this.get('id');
		},

		getTitle : function() {
			return this.get('title');
		}

	});

}(window, Backbone));
