<script class="template" id="blog_item" type="text/html">
	<li class="blog">
		<a href="#blog/view/<%= blog.getId() %>"><%= blog.getTitle() %>
	</a>
</script>

<script class="template" id="blog_view" type="text/html">
	<a href="#blog/list">zurück zur Blogliste</a>

    <h1><%= blog.getTitle() %></h1>

	<form class="new-post" action="?controller=Post&action=create" method="post">
		<input type="hidden" name="blogId" value="<%= blog.getId() %>" />
		<!--label for="contents">Post new message</label-->
		<textarea name="content"></textarea>
		<input type="button" name="submit" value="Post it!" />
	</form>

	<ul class="posts">
		<% new Backbone.Collection(posts.where({blogId: blog.getId()})).each(function(post, k) { %>
			<li class="post">
				<%= post.id %> : <%= post.getContent() %>
				<ul class="comments">
					<% new Backbone.Collection(comments.where({postId : post.id})).each(function(comment, k) { %>
						<li class="comment">
							<%= comment.getContent() %>
						</li>
					<% }) %>
					<li>
						<form class="new-comment" action="?controller=Blog&action=comment" method="post">
							<input type="hidden" name="post_id" value="<%= post.id %>" />
							<label for="contents" class="post-new-commt">Post new comment</label>
							<div class="comment-area" style="display: none">
								<textarea name="content"></textarea>
								<input type="button" name="submit" value="Comment it!" />
							</div>
						</form>
					</li>
				</ul>
			</li>
		<% }) %>
	</ul>
</script>

<div id="app"></div>
