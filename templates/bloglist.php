<ul>
<?php foreach ($blogs as $blog): ?>

	<li><a href="?controller=Blog&action=show&id=<?=$blog->id?>"><?=$blog->title?></a>

<?php endforeach; ?>
</ul>
