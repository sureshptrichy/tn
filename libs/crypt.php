<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Crypt Wrapper.
 *
 * @package   Crypt
 * @author    Russ Porosky <russ@indyarmy.com>
 * @license   MIT
 * @link      http://indyarmy.com/
 * @copyright 2013 IndyArmy Network, Inc.
 */

/**
 * Crypt class.
 *
 * @see     Crypt::hashString() Creates a Blowfish hash for the provided text using provided factor.
 * @see     Crypt::checkHashedString() Verifies that a text/hash combination is valid.
 * @see     Crypt::encrypt() Encrypt text using provided key.
 * @see     Crypt::decrypt() Decrypt text using provided key.
 * @package Crypt
 * @author  Russ Porosky <russ@indyarmy.com>
 */
class Crypt {
	/**
	 * Create a Blowfish hash for the provided text.
	 *
	 * @param string $text   The text to be hashed.
	 * @param int    $factor The work factor to use (default=11).
	 *
	 * @return string A Blowfish hash.
	 */
	public static function hashString($text, $factor = 10) {
		$salt = self::createBlowfishSalt($factor);
		return self::getHash($text, $salt);
	}

	/**
	 * Check that a hash matches plaintext.
	 *
	 * @param string $text Original text to compare.
	 * @param string $hash The stored hash to compare.
	 *
	 * @return bool Whether the hash and text are related.
	 */
	public static function checkHashedString($text, $hash) {
		$checkHash = crypt($text, $hash);
		return ($checkHash === $hash);
	}

	/**
	 * Encrypts a string using Rijndael with a 256-bit (32 character) salt.
	 *
	 * @param string $text The text to encrypt.
	 * @param string $key  The encryption key to use.
	 * @param string $iv   The optional initialization vector to use.
	 *
	 * @return string Base64 encoded encrypted text.
	 */
	public static function encrypt($text, $key, $iv = NULL) {
		assert(TRUE === is_string(base64_encode($text)));
		assert(TRUE === is_string(base64_encode($key)));
		assert(TRUE === is_null($iv) || TRUE === is_string(base64_encode($iv)));
		$return = $text;
		if (FALSE === isset($iv)) {
			$iv = mhash(MHASH_SHA256, $key);
		}
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
		$key = substr(self::pad($key, mcrypt_enc_get_key_size($cipher)), 0, mcrypt_enc_get_key_size($cipher));
		$iv = substr(self::pad($iv, mcrypt_enc_get_iv_size($cipher)), 0, mcrypt_enc_get_iv_size($cipher));
		if (mcrypt_generic_init($cipher, $key, $iv) !== -1) {
			$return = mcrypt_generic($cipher, $text);
			mcrypt_generic_deinit($cipher);
			$return = base64_encode($return);
		}
		return $return;
	}

	/**
	 * Decrypts a Base64 encoded string that was encrypted by "encrypt".
	 *
	 * @param string $text The Base64 text to decrypt.
	 * @param string $key  The encryption key to use.
	 * @param string $iv   The initialization vector to use.
	 *
	 * @return string Decrypted text or binary string.
	 */
	public static function decrypt($text, $key, $iv = NULL) {
		assert(TRUE === is_string($text));
		assert(TRUE === is_string(base64_encode($key)));
		assert(TRUE === is_NULL($iv) || TRUE === is_string(base64_encode($iv)));
		$return = $text;
		if (FALSE === isset($iv)) {
			$iv = mhash(MHASH_SHA256, $key);
		}
		$text = base64_decode($text);
		$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
		$key = substr(self::pad($key, mcrypt_enc_get_key_size($cipher)), 0, mcrypt_enc_get_key_size($cipher));
		$iv = substr(self::pad($iv, mcrypt_enc_get_iv_size($cipher)), 0, mcrypt_enc_get_iv_size($cipher));
		if (mcrypt_generic_init($cipher, $key, $iv) !== -1) {
			$return = mdecrypt_generic($cipher, $text);
			mcrypt_generic_deinit($cipher);
		}
		return trim($return);
	}

	/**
	 * Creates a Blowfish hash for the provided text and salt.
	 *
	 * @param string $text The text to be hashed.
	 * @param string $salt A salt to use for the hash.
	 *
	 * @return string A 32 character hash.
	 */
	private static function getHash($text, $salt) {
		assert(TRUE === is_string(base64_encode($text)));
		assert(TRUE === is_string($salt));
		$return = crypt($text, $salt);
		return $return;
	}

	/**
	 * Creates a randomized string of binary goodness.
	 *
	 * @param int $length Number of bytes of data to return.
	 *
	 * @return string Randomly generated binary noise.
	 */
	private static function createBinarySalt($length = 128) {
		assert(TRUE === is_int($length));
		$return = self::createSalt(self::fyshuffle(range(0, 255)), $length, TRUE);
		return $return;
	}

	/**
	 * Creates a randomized hash suitable for Blowfish one-way hashing.
	 *
	 * @param int $factor Work factor for Blowfish algorithm (between 08 and 12, leading-zero, default=11).
	 *
	 * @return string Randomly generated Blowfish 22 character salt with cost prefix.
	 */
	private static function createBlowfishSalt($factor = 07) {
		$return = "$2a$" . $factor . "$" . self::createSalt(self::fyshuffle(array_merge(range("a", "z"), range("A", "Z"), range(0, 1), array("/", "."))), 22);
		return $return;
	}

	/**
	 * Creates a salt of a specified length from an array of valid characters. Can be text or binary. Uses a Fisher-Yates shuffle algorithm to improve random distribution.
	 *
	 * @param array $valid  An array of valid character or binary values.
	 * @param int   $length The number of characters to return.
	 * @param bool  $binary If TRUE, the salt will be in binary format (default is FALSE).
	 *
	 * @return string A randomized jumble of salty goodness.
	 */
	private static function createSalt($valid, $length = 128, $binary = FALSE) {
		assert(TRUE === is_array($valid));
		assert(TRUE === is_int($length));
		assert(TRUE === is_bool($binary));
		$return = NULL;
		for ($i = 0; $i < $length; $i++) {
			if (TRUE === $binary) {
				$return .= chr($valid[mt_rand(0, count($valid) - 1)]);
			} else {
				$return .= $valid[mt_rand(0, count($valid) - 1)];
			}
		}
		$return = implode('', self::fyshuffle(str_split($return, 1)));
		return $return;
	}

	/**
	 * Performs a Fisher-Yates shuffle on input array. Does not affect original.
	 *
	 * @param array $array Array of values to shuffle.
	 *
	 * @return array Shuffled array.
	 */
	private static function fyshuffle($array) {
		assert(TRUE === is_array($array));
		$i = count($array);
		while (--$i) {
			$j = mt_rand(0, $i);
			if ($i != $j) {
				$tmp = $array[$j];
				$array[$j] = $array[$i];
				$array[$i] = $tmp;
			}
		}
		return $array;
	}

	/**
	 * Pads or trims a string to the specified number of characters.
	 *
	 * @param string $text   String or binary string to pad.
	 * @param int    $length The number of characters to return.
	 * @param string $char   Optionally, the character used to pad the string.
	 *
	 * @return string The padded or trimmed string.
	 */
	private static function pad($text, $length, $char = ' ') {
		assert(TRUE === is_string(base64_encode($text)));
		assert(TRUE === is_int($length));
		assert(TRUE === is_string($char));
		$return = $text;
		if (mb_strlen($text) < $length) {
			$return = mb_str_pad($text, $length, $char);
		}
		if (mb_strlen($text) > $length) {
			$return = mb_substr($text, 0, $length);
		}
		return $return;
	}
}
