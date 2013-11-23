/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone) {
	'use strict';

	app.Comment = Backbone.Model.extend({

		urlRoot : '?controller=Comment',

		url : function() {
			if (this.isNew()) {
				return this.urlRoot;
			}

			return this.urlRoot + '&id=' + this.id;
		},

		getPostId : function() {
			return this.get('postId');
		},

		getContent : function() {
			return this.get('content');
		}

	});

}(window, Backbone));
