<?php

namespace helper;

class Sanitizer {

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
			} else if (!preg_match('/^[0-9]$/', $integer)) {
				return false;
			}
		}

		return true;
	}

}
