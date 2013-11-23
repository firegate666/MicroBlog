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
			if (!preg_match('/^[0-9]$/', $integer)) {
				return false;
			}
		}

		return true;
	}

}
