<ul class="blogs">
<?php foreach ($blogs as $blog): ?>

	<li class="blog"><a href="?controller=Blog&action=show&id=<?=$blog->id?>"><?=$blog->title?></a>

<?php endforeach; ?>
</ul>
