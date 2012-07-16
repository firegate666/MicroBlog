<form class="new-post" action="?controller=Blog&action=post">
	<input type="hidden" name="blog_id" value="<?=$blog->id?>" />
	<label for="contents">Post new message</label>
	<textarea name="contents"></textarea>
	<input type="submit" />
</form>
