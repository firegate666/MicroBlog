<?php

namespace helper;

class Sanitizer {

	const ALL_INT = '/^[0-9]$/';

	/**
	 * Test that all given values are integers
	 *
	 * @param array $integers
	 * @return boolean
	 */
	public static function validateAllInt(array $integers) {
		foreach ($integers as $integer) {
			if (is_bool($integer) || is_array($integer)) {
				return false;
			} else if (!preg_match(static::ALL_INT, $integer)) {
				return false;
			}
		}

		return true;
	}
}
