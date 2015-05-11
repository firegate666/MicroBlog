/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone) {
	'use strict';

	app.Post = Backbone.Model.extend({

		/**
		 * @property {string}
		 */
		urlRoot : '?controller=Post&action=update',

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
		 * @returns {string}
		 */
		getContent : function() {
			return this.get('content');
		}

	});

}(window, Backbone));
