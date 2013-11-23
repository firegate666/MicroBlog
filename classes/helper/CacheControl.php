<?php

namespace helper;

/**
 * class for cache control
 *
 * @author marco@behnke.biz
 * @link https://gist.github.com/1447045
 */
final class CacheControl {

	private function __construct() {
		// no instances
	}

	/**
	 * calculate etag for filename and params
	 *
	 * @param String $filename
	 * @param array $params relevant request parameters for etag calculation
	 * @return String
	 */
	public static function etag($filename, $params = array()) {
		$etag = fileinode($filename) . '-' . filemtime($filename) . '-' . filesize($filename);
		$params = var_export($params, true);
		return '"' . md5($etag . $params) . '"';
	}

	/**
	 * calculate last modified for filename
	 *
	 * @param String $filename
	 * @return String
	 */
	public static function last_modified($filename) {
		return date('r', filemtime($filename));
	}

	/**
	 * test if filename is not modified since
	 *
	 * @param String $filename
	 * @param boolean $send_header if true send Last-Modified header
	 * @return boolean
	 */
	public static function is_not_modified_since_file($filename, $send_header = true) {
		$last_modified = self::last_modified($filename);

		if ($send_header) {
			header("Last-Modified: $last_modified", true);
		}

		return self::is_not_modified_since($last_modified);
	}

	/**
	 * test if filename matches
	 *
	 * @param String $filename
	 * @param array $params
	 * @param boolean $send_header if true send Etag header
	 * @return boolean
	 */
	public static function etag_matches_file($filename, $params = array(), $send_header = true) {
		$etag = self::etag($filename, $params);

		if ($send_header) {
			header("Etag: $etag", true);
		}

		return self::etag_matches($etag);
	}

	/**
	 * test if etag matches
	 *
	 * @global $_SERVER ['HTTP_IF_NONE_MATCH']
	 * @param String $etag
	 * @return boolean
	 */
	public static function etag_matches($etag) {
		$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
			stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) :
			false;

		if ($if_none_match && $if_none_match == $etag) {
			return true;
		}
		return false;
	}

	/**
	 * test if modified since
	 *
	 * @global $_SERVER ['HTTP_IF_MODIFIED_SINCE']
	 * @param String $last_modified
	 * @return boolean
	 */
	public static function is_not_modified_since($last_modified) {
		$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
			stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
			false;

		if ($if_modified_since && $if_modified_since == $last_modified) {
			return true;
		}
		return false;
	}

	/**
	 * send 304 and exit()
	 */
	public static function send_not_modified_since() {
		header('HTTP/1.0 304 Not Modified');
		exit;
	}
}
