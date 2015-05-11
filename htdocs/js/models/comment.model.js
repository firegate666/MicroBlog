/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone) {
	'use strict';

	app.Comment = Backbone.Model.extend({

		/**
		 * @property {string}
		 */
		urlRoot : '?controller=Comment',

		/**
		 * get rest url for this model
		 *
		 * @returns {string}
		 */
		url : function() {
			if (this.isNew()) {
				return this.urlRoot;
			}

			return this.urlRoot + '&id=' + this.id;
		},

		/**
		 * @returns {Number}
		 */
		getId : function() {
			return this.get('id');
		},

		/**
		 * @returns {Number}
		 */
		getPostId : function() {
			return this.get('postId');
		},

		/**
		 * @returns {string}
		 */
		getContent : function() {
			return this.get('content');
		}

	});

}(window, Backbone));
