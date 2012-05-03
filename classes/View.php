<?php

class View
{

	public $template;

	/**
	 * load layout and render with given parameters
	 *
	 * @param string $layout
	 * @param array $parameters
	 * @return string
	 */
	public function render($layout, $parameters = array())
	{
		extract($parameters);
		ob_start();
		include __DIR__ . '/../templates/' . $layout . '.php';
		return ob_get_clean();
	}
}
