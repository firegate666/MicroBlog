/*jslint browser: true*/
/*global Backbone, _*/

(function(app, Backbone, us){
	'use strict';

	app.BlogsView = Backbone.View.extend({

		tagName: 'ul',
		id: 'blogs',

		initialize: function() {
			this.listenTo(this.collection, 'add', this.render); // collection event binder
			this.render();
		},

		/**
		 * render book list
		 */
		render: function() {
			var self = this;

			this.$el.empty();
			us.each(this.collection.models, function(item){ // in case collection is not empty
				self.$el.append(us.template(app.TM.getTemplate('blog_item'), {blog: item}));
			}, this);
		}
	});

}(window, Backbone, _));
