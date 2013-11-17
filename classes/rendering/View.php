<?php

namespace rendering;

use helper\FileReader;

class View
{

	/**
	 *
	 * @var array
	 */
	public $rendering_config;

	/**
	 *
	 * @var FileReader
	 */
	private $file_reader;


	public function __construct(array $rendering_config, FileReader $file_reader)
	{
		$this->rendering_config = $rendering_config;
		$this->file_reader = $file_reader;
	}

	/**
	 * get path to template folder
	 *
	 * @return string
	 */
	protected function getLayoutBasePath() {
		if (array_key_exists('layout_base_path', $this->rendering_config)) {
			return $this->rendering_config['layout_base_path'];
		}

		return TEMPLATES_DEFAULT;
	}

	/**
	 * load layout and render with given parameters
	 *
	 * @param string $layout
	 * @param array $parameters
	 * @param string $wrap
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

		$layout_file = $this->getLayoutBasePath() . $layout . '.php';
		if (!$this->file_reader->file_exists($layout_file))
		{
			throw new \InvalidArgumentException(sprintf('selected layout "%s" not found', $layout_file), 404);
		}

		extract($parameters);
		ob_start();
		/** @todo how can this be handled by file reader? */
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
