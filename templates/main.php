<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Micro | Blog</title>
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/main.css" />

		<script src="js/lib/require.js"></script>

		<script src="js/lib/jquery-2.0.0.js"></script>

		<script src="js/lib/json2.js" type="text/javascript"></script>
		<script src="js/lib/underscore-1.4.4.js" type="text/javascript"></script>
		<script src="js/lib/backbone-1.0.0.js" type="text/javascript"></script>

		<script type="text/javascript" src="js/models/blog.model.js"></script>
		<script type="text/javascript" src="js/models/post.model.js"></script>
		<script type="text/javascript" src="js/models/comment.model.js"></script>

		<script type="text/javascript" src="js/collections/blogs.collection.js"></script>
		<script type="text/javascript" src="js/collections/posts.collection.js"></script>
		<script type="text/javascript" src="js/collections/comments.collection.js"></script>

		<script type="text/javascript" src="js/views/blogs.view.js"></script>
		<script type="text/javascript" src="js/views/blog.view.js"></script>

		<script type="text/javascript" src="js/template_manager.js"></script>
		<script type="text/javascript" src="js/app.js"></script>
		<script type="text/javascript" src="js/main_router.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>

		<!--script type="text/javascript" src="js/main.js"></script-->
	</head>
<body>

	<div id="content">
		<?= $content ?>

		<div id="footer">
			&copy; 2012 - 2013 Marco Behnke
		</div>

	</div>

</body>
</html>
