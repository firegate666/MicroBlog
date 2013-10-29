<script class="template" id="blog_item" type="text/html">
	<li class="blog">
		<a href="#blog/view/<%= blog.getId() %>"><%= blog.getTitle() %>
	</a>
</script>

<script class="template" id="blog_view" type="text/html">
	<a href="#blog/list">zurück zur Blogliste</a>

    <h1><%= blog.getTitle() %></h1>

	<% posts.each(function(v, k) {
		console.log(k, v);
	}) %>
</script>

<div id="app"></div>
