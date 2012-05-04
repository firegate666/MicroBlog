<?php
namespace rendering;

class View
{

	public function __construct(array $rendering_config) {
		$this->rendering_config = $rendering_config;
	}

	public $rendering_config;

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
		include $this->rendering_config['layout_base_path'] . $layout . '.php';
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
