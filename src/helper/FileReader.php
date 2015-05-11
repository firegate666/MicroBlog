<?php
namespace helper;

/**
 * File system accessor
 *
 * @package helper
 */
class FileReader {

	/**
	 * read content from filesystem
	 *
	 * @param string $filename
	 * @param boolean $useIncludePath
	 * @param resource $context
	 * @param integer $offset
	 * @param integer $maxlen
	 * @return string
	 */
	public function fileGetContents($filename, $useIncludePath = false, $context = null, $offset = -1, $maxlen = null) {
		if (!$this->fileExists($filename)) {
			throw new FileNotFoundException($filename);
		}
		return file_get_contents($filename, $useIncludePath, $context, $offset, $maxlen);
	}

	/**
	 * Test if file exists
	 *
	 * @param string $filename
	 * @return boolean
	 */
	public function fileExists($filename) {
		return file_exists($filename);
	}
}
