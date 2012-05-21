<!DOCTYPE html>
<html>
	<head>
		<title>Micro | Blog</title>
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/main.css" />

		<script type="text/css"
			<?php if (defined('APP_ENV_DEBUG') && APP_ENV_DEBUG): ?>
				src="http://code.jquery.com/jquery-1.7.2.js"
			<?php else: ?>
				src="http://code.jquery.com/jquery-1.7.2.min.js"
			<?php endif; ?>
		></script>
	</head>
<body>

	<div id="content">
		<?=$content?>

		<div id="footer">
			&copy; 2012 Marco Behnke
		</div>

	</div>

</body>
</html>
