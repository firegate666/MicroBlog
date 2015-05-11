/*jslint browser: true*/
/*global Backbone*/

(function(app, Backbone) {
	'use strict';

	app.Blog = Backbone.Model.extend({

		/**
		 * @property {string}
		 */
		urlRoot : '?controller=Blog',

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
		getTitle : function() {
			return this.get('title');
		}

	});

}(window, Backbone));
