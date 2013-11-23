<?php

namespace rendering;

use helper\FileReader;

class View implements RenderingInterface {

	/**
	 *
	 * @var array
	 */
	public $renderingConfig;

	/**
	 *
	 * @var FileReader
	 */
	private $fileReader;

	/**
	 * @param array $renderingConfig
	 * @param FileReader $fileReader
	 */
	public function __construct(array $renderingConfig, FileReader $fileReader) {
		$this->renderingConfig = $renderingConfig;
		$this->fileReader = $fileReader;
	}

	/**
	 * get path to template folder
	 *
	 * @return string
	 */
	protected function getLayoutBasePath() {
		if (array_key_exists('layout_base_path', $this->renderingConfig)) {
			return $this->renderingConfig['layout_base_path'];
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
	public function render($layout, $parameters = array(), $wrap = 'main') {
		static $clearBuffer;
		if ($clearBuffer === null) {
			ob_clean();
			$clearBuffer = false;
		}

		$layoutFile = $this->getLayoutBasePath() . $layout . '.php';
		if (!$this->fileReader->fileExists($layoutFile)) {
			throw new \InvalidArgumentException(sprintf('selected layout "%s" not found', $layoutFile), 404);
		}

		extract($parameters);
		ob_start();
		/** @todo how can this be handled by file reader without eval? */
		include $layoutFile;
		$content = ob_get_clean();

		if ($wrap === null) {
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
	public function renderPartial($layout, $parameters) {
		return $this->render($layout, $parameters, null);
	}
}
