<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * URL routing class.
 *
 * @package    truenorthng
 * @subpackage Router
 */

class Url extends Object {
	public function __construct(G $G, $basepath) {
		parent::__construct($G);
		$this->basepath = $basepath;
		$this->url = $this->processURL();
		$this->querystring = $this->processQuerystring();
		$this->ajax = FALSE;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$this->ajax = TRUE;
		}
		if ($this->getQuerystringBit('ajax') == 'true') {
			$this->ajax = TRUE;
		}
		//Log::write($this->getUrl() . $this->getQuerystring(TRUE) . ': ' . $this->getPost(TRUE), 'access');
	}

	public function __toString() {
		return $this->getUrl() . $this->getQuerystring(TRUE);
	}

	/**
	 * Returns the URL portion of the URI, with trailing slash.
	 *
	 * @var bool $asArray Return an array of URI bits instead.
	 * @return string|array
	 */
	public function getUrl($asArray = FALSE) {
		$return = $this->basepath . $this->url;
		if (substr($return, -1, 1) != '/') {
			$return .= '/';
		}
		if ($asArray) {
			$return = explode("/", trim($return, "/"));
		}
		return $return;
	}

	public function parentUrl($times = 1, $end = NULL) {
		$url = $this->urlBits;
		for ($i = 0; $i < $times; $i++) {
			array_pop($url);
		}
		if ($end != null){
			return $url[$times];
		}
		return implode('/', $url);
	}

	/**
	 * Returns a specific portion of the URL.
	 *
	 * @param int $bit
	 *
	 * @return string
	 */
	public function getUrlBit($bit) {
		$return = NULL;
		if (isset($this->urlBits[$bit])) {
			$return = $this->urlBits[$bit];
		}
		return $return;
	}

	public function getPost($json = FALSE) {
		$return = array();
		if (isset($_POST)) {
			$return = $_POST;
		}
		if ($json) {
			$return = json_encode($return);
		}
		return $return;
	}

	public function getPostBit($key) {
		$return = NULL;
		if (isset($_POST[$key])) {
			$return = $_POST[$key];
		}
		return $return;
	}

	/**
	 * Returns the complete querystring, "?" is optional.
	 *
	 * @param bool $showQMark
	 *
	 * @return string
	 */
	public function getQuerystring($showQMark = FALSE) {
		$return = NULL;
		if ($showQMark && $this->querystring) {
			$return = '?';
		}
		$return .= $this->querystring;
		return $return;
	}

	/**
	 * Returns a specific value from the querystring.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function getQuerystringBit($key) {
		$return = NULL;
		if (isset($this->querystringBits[$key])) {
			$return = $this->querystringBits[$key];
		}
		return $return;
	}

	/**
	 * Returns the querystring and stores it in an array.
	 *
	 * @return string
	 */
	private function processQuerystring() {
		$return = NULL;
		if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
			$return = $_SERVER['QUERY_STRING'];
		}
		parse_str($return, $this->data['querystringBits']);
		return $return;
	}

	/**
	 * Returns the current URL (without base path) and stores it in an array.
	 *
	 * @return string
	 */
	private function processURL() {
		$return = NULL;
		if (isset($_SERVER['HTTP_X_ORIGINAL_URL']) && $_SERVER['HTTP_X_ORIGINAL_URL'] != '') {
			$return = $_SERVER['HTTP_X_ORIGINAL_URL'];
		} elseif (isset($_SERVER['HTTP_X_REWRITE_URL']) && $_SERVER['HTTP_X_REWRITE_URL'] != '') {
			$return = $_SERVER['HTTP_X_REWRITE_URL'];
		} elseif (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '') {
			$return = $_SERVER['REQUEST_URI'];
		} elseif (isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] != '') {
			$return = $_SERVER['REDIRECT_URL'];
		}
		$return = str_replace_once($this->basepath, '', $return);
		if (strpos($return, '?')) {
			$return = substr($return, 0, strpos($return, '?'));
		}
		$return = trim($return, '/');
		$this->urlBits = explode('/', $return);
		return $return;
	}

	/**
	 * Compare the passed URL against the request URL.
	 *
	 * @param string $request
	 *
	 * @return bool TRUE if both URLs are the same.
	 */
	public function isCurrent($request) {
		$current = trim($this->getUrl(), '/');
		//echo "<PRE>$current - $request</PRE>";
		if ($current == '') {
			$current = $this->G->defaultController;
		}
		if ($current == trim($request, '/')) {
			return TRUE;
		}
		return FALSE;
	}
}
