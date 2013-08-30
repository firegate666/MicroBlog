/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone) {
	'use strict';

	app.Blog = Backbone.Model.extend({

		urlRoot : 'book/',

		url : function() {
			if (this.isNew()) {
				return this.urlRoot;
			}

			return this.urlRoot + '?id=' + this.id;
		}

	});

}(window, Backbone));
