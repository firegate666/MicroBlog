/*jslint browser: true*/
/*global Backbone, _*/

(function(app, Backbone, us){
	'use strict';

	app.BlogView = Backbone.View.extend({

		tagName: 'div',
		id: 'blog',

		initialize: function() {
			this.listenTo(this.model, 'change', this.render); // collection event binder
			this.render();
		},

		/**
		 * render book list
		 */
		render: function() {
			this.$el.append(us.template(app.TM.getTemplate('blog_view'), {blog: this.model}));
		},

	});

}(window, Backbone, _));