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
			this.listenTo(this.model, 'change', this.reRender); // collection event binder
			this.listenTo(this.collection.posts, 'add', this.reRender);
			this.listenTo(this.collection.comments, 'add', this.reRender);
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
			this.$el.find('form.new-post input[type="button"][name="submit"]').on('click', this.handlePost.bind(this));
			this.$el.find('form.new-comment input[type="button"][name="submit"]').on('click', this.handleComment.bind(this));

			this.$el.find('.new-comment .post-new-commt').on('click', function() {
				$(this).parent().find('.comment-area').toggle();
			});
		},

		handleComment: function(event) {
			var $el = $(event.currentTarget).parents('form.new-comment:first');
			var content = $el.find('textarea[name="content"]').val(),
				postId = parseInt($el.find('input[name="post_id"]').val(), 10),
				comment = new app.Comment();

			comment.save({
					postId: postId,
					content: content
				},
				{
					success: this.handleCommented.bind(this, comment)
				}
			);
		},

		/**
		 * callback on click submit
		 * fill new post model with data and save it
		 *
		 * @return void
		 */
		handlePost: function() {
			var content = this.$el.find('form.new-post textarea[name="content"]').val(),
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
		 * @param {app.Post} new_post
		 * @return void
		 */
		handleSubmitted: function(new_post) {
			this.collection.posts.add(new_post);
		},

		handleCommented: function(new_comment) {
			this.collection.comments.add(new_comment);
		},

		reRender: function() {
			console.log('re-render', this.collection);
			this.$el.html('');
			this.render();
			this.registerViewComponents();
		},

		/**
		 * render book list
		 *
		 * @returns {void}
		 */
		render: function() {
			this.$el.append(us.template(app.TM.getTemplate('blog_view'), {
                blog : this.model,
                posts : this.collection.posts,
				comments : this.collection.comments
            }));
		}

	});

}(window, Backbone, _));
