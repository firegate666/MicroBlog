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
	public function render($layout, $parameters = array(), $wrap = 'main')
	{
		extract($parameters);
		ob_start();
		include __DIR__ . '/../templates/' . $layout . '.php';
		$content = ob_get_clean();
		
		if ($wrap === null)
		{
			return $content;
		}
		return $this->render($wrap, array('content' => $content), null);
	}

	/**
	 * render layout without wrap
	 * 
	 * @uses View::render()
	 * @param string $layout
	 * @param array $parameters
	 * @return string
	 */
	public function renderPartial($layout, $parameters)
	{
		return $this->render($layout, $parameters, null);
	}
}
