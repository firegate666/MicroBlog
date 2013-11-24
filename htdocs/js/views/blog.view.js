/*jslint browser: true*/
/*global Backbone, _*/

(function(app, Backbone, us){
	'use strict';

	app.BlogView = Backbone.View.extend({

		/**
		 * @property {string}
		 */
		tagName: 'div',

		/**
		 * @property {string}
		 */
		id: 'blog',

		/**
		 * initialize listener and trigger render
		 *
		 * @returns {void}
		 */
		initialize: function() {
			this.listenTo(this.model, 'change', this.render); // collection event binder
			this.render();
		},

		/**
		 * render book list
		 *
		 * @returns {void}
		 */
		render: function() {
			this.$el.html('');
			this.$el.append(us.template(app.TM.getTemplate('blog_view'), {
                blog : this.model,
                posts : this.collection.posts,
				comments : this.collection.comments
            }));
		}

	});

}(window, Backbone, _));
