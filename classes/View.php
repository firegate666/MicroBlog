<?php

class View
{
	public $template;
	
	public function render($layout, $parameters = array()) {
		extract($parameters);
		$content = include __DIR__ . '/../templates/'.$layout.'.php';
		return $content;
	}
}

?>