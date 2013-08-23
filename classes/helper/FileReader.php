<?php
namespace helper;

class FileReader {

	/**
	 *
	 * @param string $filename
	 * @param boolean $use_include_path
	 * @param resource $context
	 * @param integer $offset
	 * @param integer $maxlen
	 * @return string
	 */
	public function file_get_contents($filename, $use_include_path = false, $context = null, $offset = -1, $maxlen = null) {
		return file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
	}

	/**
	 *
	 * @param string $filename
	 * @return boolean
	 */
	public function file_exists($filename) {
		return file_exists($filename);
	}
}