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
			this.listenTo(this.collection.posts, 'add', this.render);
			this.render();

			this.registerViewComponents();
		},

		/**
		 * register view components
		 * submit button
		 *
		 * @return void
		 */
		registerViewComponents: function() {
			this.$el.find('input[type="button"][name="submit"]').on('click', this.handleSubmit.bind(this));
		},

		/**
		 * callback on click submit
		 * fill new post model with data and save it
		 *
		 * @return void
		 */
		handleSubmit: function() {
			var content = this.$el.find('textarea[name="content"]').val(),
				post = new app.Post();

			post.save({
					blogId: this.model.getId(),
					content: content
				},
				{
					success: this.handleSubmitted.bind(this, post)
				}
			);
		},

		/**
		 * Handle successful submit, add new post to collection
		 *
		 * @param app.Post new_post
		 * @return void
		 */
		handleSubmitted: function(new_post) {
			this.collection.posts.add(new_post);
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
