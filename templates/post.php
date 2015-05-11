<li class="post">
	<?=$post->content?>
	<ul class="comments">
		<?php foreach ($post->comments as $comment): ?>
			<?=$this->renderPartial('comment', array('comment' => $comment))?>
		<?php endforeach; ?>
	</ul>
	<?= $this->renderPartial('commentform', array('post' => $post)) ?>
</li>
