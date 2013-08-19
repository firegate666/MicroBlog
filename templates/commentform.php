<form class="new-comment" action="?controller=Blog&action=comment">
	<input type="hidden" name="post_id" value="<?= $post->id ?>" />
 	<label for="contents">Post new comment</label>
	<textarea name="contents"></textarea>
	<input type="submit" />
</form>
