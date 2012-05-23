<div class="backlink"><a href="?controller=Blog">zurück zur Blogliste</a></div>

<h1><?=$blog->title?></h1>

<?=$this->renderPartial('postform', array())?>
<ul class="posts">
	<?php foreach ($blog->posts as $post): ?>
		<?=$this->renderPartial('post', array('post' => $post))?>
	<?php endforeach; ?>
</ul>
