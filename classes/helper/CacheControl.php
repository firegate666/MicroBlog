<?php

namespace helper;

/**
 * class for cache control
 *
 * @author marco@behnke.biz
 * @link https://gist.github.com/1447045
 */
final class CacheControl {

	/**
	 * no instances shall be created
	 */
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
	public static function lastModified($filename) {
		return date('r', filemtime($filename));
	}

	/**
	 * test if filename is not modified since
	 *
	 * @param String $filename
	 * @param boolean $sendHeader if true send Last-Modified header
	 * @return boolean
	 */
	public static function isNotModifiedSinceFile($filename, $sendHeader = true) {
		$lastModified = self::lastModified($filename);

		if ($sendHeader) {
			header("Last-Modified: $lastModified", true);
		}

		return self::isNotModifiedSince($lastModified);
	}

	/**
	 * test if filename matches
	 *
	 * @param Request $request
	 * @param String $filename
	 * @param array $params
	 * @param boolean $sendHeader if true send Etag header
	 * @return boolean
	 */
	public static function etagMatchesFile(Request $request, $filename, $params = array(), $sendHeader = true) {
		$etag = self::etag($filename, $params);

		if ($sendHeader) {
			header("Etag: $etag", true);
		}

		return self::etagMatches($request, $etag);
	}

	/**
	 * test if etag matches
	 *
	 * @param Request $request
	 * @param String $etag
	 * @return boolean
	 */
	public static function etagMatches(Request $request, $etag) {
		$ifNoneMatch = $request->serverVar('HTTP_IF_NONE_MATCH', false);

		if ($ifNoneMatch && $ifNoneMatch == $etag) {
			return true;
		}
		return false;
	}

	/**
	 * test if modified since
	 *
	 * @param Request $request
	 * @param String $lastModified
	 * @return boolean
	 */
	public static function isNotModifiedSince(Request $request, $lastModified) {
		$ifModifiedSince = $request->serverVar('HTTP_IF_MODIFIED_SINCE', false);

		if ($ifModifiedSince && $ifModifiedSince == $lastModified) {
			return true;
		}
		return false;
	}

	/**
	 * send 304
	 *
	 * @return void
	 */
	public static function sendNotModifiedSince() {
		header('HTTP/1.0 304 Not Modified');
	}
}
