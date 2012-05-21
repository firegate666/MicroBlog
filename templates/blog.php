<h1><?=$title?></h1>

<?=$this->renderPartial('postform', array())?>
<ul class="posts">
	<?=$this->renderPartial('post', array())?>
</ul>
