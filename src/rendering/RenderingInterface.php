<?php

namespace rendering;

use InvalidArgumentException;

interface RenderingInterface {

	/**
	 * load layout and render with given parameters
	 *
	 * @param string $layout
	 * @param array $parameters
	 * @param string $wrap
	 * @throws InvalidArgumentException if layout is not found
	 * @return string
	 */
	public function render($layout, $parameters = array(), $wrap = 'main');

	/**
	 * render layout without wrap
	 *
	 * @uses View::render()
	 * @param string $layout
	 * @param array $parameters
	 * @return string
	 */
	public function renderPartial($layout, $parameters);
}
