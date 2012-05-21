<?php

namespace rendering;

class View
{

	public function __construct(array $rendering_config)
	{
		$this->rendering_config = $rendering_config;
	}

	/**
	 *
	 * @var array
	 */
	public $rendering_config;

	/**
	 * load layout and render with given parameters
	 *
	 * @param string $layout
	 * @param array $parameters
	 * @throws \InvalidArgumentException if layout is not found
	 * @return string
	 */
	public function render($layout, $parameters = array(), $wrap = 'main')
	{
		static $clear_buffer;
		if ($clear_buffer === null)
		{
			ob_clean();
			$clear_buffer = false;
		}

		$layout_file = $this->rendering_config['layout_base_path'] . $layout . '.php';
		if (! file_exists($layout_file))
		{
			throw new \InvalidArgumentException('selected layout not found', 404);
		}

		extract($parameters);
		ob_start();
		include $layout_file;
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
