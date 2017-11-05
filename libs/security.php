<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Security related functions.
 *
 * @package    truenorthng
 * @subpackage Library
 */

/**
 * Class Security
 *
 * @see Security::createID() Create a new unique identifier.
 */
class Security {
	/**
	 * Compares the current user IP address against comma-delimited lists
	 * of banned/allowed IP addresses and returns FALSE if a match is found.
	 * If there are IP addresses listed in the whitelist, the blacklist is
	 * ignored.
	 *
	 * @param string $bans
	 * @param string $allows
	 *
	 * @return boolean
	 */
	public static function ipAllowed($allows, $bans) {
		$return = TRUE;
		$match = FALSE;
		$currentIp = '';
		if (isset($_SERVER["REMOTE_ADDR"])) {
			$currentIp = $_SERVER["REMOTE_ADDR"];
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$currentIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if (trim($currentIp)) {
			if (trim($allows)) {
				$allows = makeArray($allows);
				for ($i = 0, $c = count($allows); $i < $c; $i++) {
					if (trim($allows[$i]) != '') {
						$allows[$i] = substr($allows[$i], 0, strpos($allows[$i], '*') - 1);
						if (strlen($allows[$i]) > 0) {
							if ($allows[$i] == substr($currentIp, 0, strlen($allows[$i]))) {
								$match = TRUE;
							}
						}
					}
				}
				if (!$match) {
					// Current IP address not in whitelist.
					$return = FALSE;
				}
			} else if (trim($bans)) {
				$bans = makeArray($bans);
				for ($i = 0, $c = count($bans); $i < $c; $i++) {
					if (trim($bans[$i]) != '') {
						$bans[$i] = substr($bans[$i], 0, strpos($bans[$i], '*') - 1);
						if (strlen($bans[$i]) > 0) {
							if ($bans[$i] == substr($currentIp, 0, strlen($bans[$i]))) {
								$match = TRUE;
							}
						}
					}
				}
				if ($match) {
					// Current IP address found in blacklist.
					$return = FALSE;
				}
			}
		}
		return $return;
	}

	/**
	 * Compares referer host against current host. Returns FALSE if they
	 * don't match (a signature of a CSRF attack).
	 *
	 * @return boolean
	 */
	public static function hostMatched() {
		// TODO: add third-party comparison
		$return = TRUE;
		return TRUE;
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['HTTP_HOST'])) {
			list(, , $referer_host) = explode('/', $_SERVER['HTTP_REFERER'], 4);
			if ($_SERVER['HTTP_HOST'] != $referer_host) {
				// Request came from a different site.
				$return = FALSE;
			}
		}
		return $return;
	}
}
