/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone) {
	'use strict';

	app.Post = Backbone.Model.extend({

		urlRoot : '?controller=Post',

		url : function() {
			if (this.isNew()) {
				return this.urlRoot;
			}

			return this.urlRoot + '&id=' + this.id;
		}

	});

}(window, Backbone));
