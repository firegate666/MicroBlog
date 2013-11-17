<script class="template" id="blog_item" type="text/html">
	<li class="blog">
		<a href="#blog/view/<%= blog.getId() %>"><%= blog.getTitle() %>
	</a>
</script>

<script class="template" id="blog_view" type="text/html">
	<a href="#blog/list">zurück zur Blogliste</a>

    <h1><%= blog.getTitle() %></h1>

	<ul class="posts">
		<% posts.each(function(post, k) { %>
			<li class="post">
				<%= post.id %> : <%= post.getContent() %>
				<ul class="comments">
					<% new Backbone.Collection(comments.where({post_id : post.id})).each(function(comment, k) { %>
						<li class="comment">
							<%= comment.getContent() %>
						</li>
					<% }) %>
				</ul>
			</li>
		<% }) %>
	</ul>
</script>

<div id="app"></div>
