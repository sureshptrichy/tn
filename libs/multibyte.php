<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Multibyte aware function replacements that don't exist.
 *
 * @package    truenorthng
 * @subpackage Library
 */

mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');

if (!function_exists('mb_str_split')) {
	/**
	 * Convert a string to an array.
	 *
	 * @param string $string The input string
	 * @param int $split_length Maximum length of the chunk
	 * @return array If the optional split_length parameter is specified,
	 *  the returned array will be broken down into chunks with each being
	 *  split_length in length, otherwise each chunk will be one character
	 *  in length. FALSE is returned if split_length is less than 1. If the
	 *  split_length length exceeds the length of string, the entire string
	 *  is returned as the first (and only) array element.
	 */
	function mb_str_split($string, $split_length = 1) {
		$split_length = ($split_length <= 0) ? 1 : $split_length;
		$mb_strlen = mb_strlen($string, 'utf-8');
		$array = array();
		for($i = 0; $i < $mb_strlen; $i = $i + $split_length) {
			$array[] = mb_substr($string, $i, $split_length);
		}
		return $array;
	}
}

if (!function_exists('mb_trim')) {
	/**
	 * Strip whitespace (or other characters) from the beginning and end of
	 * a string.
	 *
	 * @param string $string The string that will be trimmed
	 * @param string $chars Optionally, the stripped characters can also be
	 *  specified using the charlist parameter. Simply list all characters
	 *  that you want to be stripped. With .. you can specify a range of
	 *  characters
	 * @param array $chars_array
	 * @return string The trimmed string
	 */
	function mb_trim($string, $chars = '', $chars_array = array()) {
		for($x=0; $x < iconv_strlen($chars); $x++) {
			$chars_array[] = preg_quote(iconv_substr($chars, $x, 1));
		}
		$encoded_char_list = implode('|', array_merge(array("\s","\t","\n","\r", "\0", "\x0B"), $chars_array));
		$string = mb_ereg_replace("^($encoded_char_list)*", '', $string);
		$string = mb_ereg_replace("($encoded_char_list)*$", '', $string);
		return $string;
	}
}

if (!function_exists('mb_ltrim')) {
	/**
	 * Strip whitespace (or other characters) from the beginning of a string.
	 *
	 * @param string $string The input string
	 * @param string $chars Optionally, the stripped characters can also be
	 *  specified using the charlist parameter. Simply list all characters
	 *  that you want to be stripped. With .. you can specify a range of
	 *  characters
	 * @param array $chars_array
	 * @return string The trimmed string
	 */
	function mb_ltrim($string, $chars = '', $chars_array = array()) {
		for($x=0; $x < iconv_strlen($chars); $x++) {
			$chars_array[] = preg_quote(iconv_substr($chars, $x, 1));
		}
		$encoded_char_list = implode('|', array_merge(array("\s","\t","\n","\r", "\0", "\x0B"), $chars_array));
		$string = mb_ereg_replace("^($encoded_char_list)*", '', $string);
		return $string;
	}
}

if (!function_exists('mb_rtrim')) {
	/**
	 * Strip whitespace (or other characters) from the end of a string.
	 *
	 * @param string $string The input string
	 * @param string $chars Optionally, the stripped characters can also be
	 *  specified using the charlist parameter. Simply list all characters
	 *  that you want to be stripped. With .. you can specify a range of
	 *  characters
	 * @param array $chars_array
	 * @return string The trimmed string
	 */
	function mb_rtrim($string, $chars = '', $chars_array = array()) {
		for($x=0; $x < iconv_strlen($chars); $x++) {
			$chars_array[] = preg_quote(iconv_substr($chars, $x, 1));
		}
		$encoded_char_list = implode('|', array_merge(array("\s","\t","\n","\r", "\0", "\x0B"), $chars_array));
		$string = mb_ereg_replace("($encoded_char_list)*$", '', $string);
		return $string;
	}
}

if (!function_exists('mb_str_pad')) {
	/**
	 * Pad a string to a certain length with another string
	 *
	 * @param string $input The input string
	 * @param int $pad_length If the value of pad_length is negative, less
	 *  than, or equal to the length of the input string, no padding takes
	 *  place
	 * @param string $pad_string The pad_string may be truncated if the
	 *  required number of padding characters can't be evenly divided by the
	 *  pad_string's length
	 * @param int $pad_type Optional argument pad_type can be STR_PAD_RIGHT,
	 *  STR_PAD_LEFT, or STR_PAD_BOTH. If pad_type is not specified it is
	 *  assumed to be STR_PAD_RIGHT
	 * @param string $encoding
	 * @return string The padded string
	 */
	function mb_str_pad ($input, $pad_length, $pad_string = '', $pad_type = STR_PAD_RIGHT, $encoding = 'UTF-8') {
		return str_pad($input, strlen($input)-mb_strlen($input,$encoding)+$pad_length, $pad_string, $pad_type);
	}
}

if (!function_exists('mb_str_replace')) {
	/**
	 * Replace all occurrences of the search string with the replacement
	 * string.
	 *
	 * @param mixed $needle The value being searched for, otherwise known as
	 *  the needle. An array may be used to designate multiple needles
	 * @param mixed $replacement The replacement value that replaces found
	 *  search values. An array may be used to designate multiple
	 *  replacements
	 * @param mixed $haystack The string or array being searched and
	 *  replaced on. If subject is an array, then the search and replace is
	 *  performed with every entry of subject, and the return value is an
	 *  array as well
	 * @param int $count If passed, this will hold the number of matched and
	 *  replaced needles
	 * @return mixed A string or an array with the replaced values
	 */
	function mb_str_replace($needle, $replacement, $haystack, &$count = null) {
		$needle_len = mb_strlen($needle);
		$replacement_len = mb_strlen($replacement);
		$pos = mb_strpos($haystack, $needle);
		while ($pos !== false) {
			$haystack = mb_substr($haystack, 0, $pos).$replacement.mb_substr($haystack, $pos + $needle_len);
			$pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
			if (isset($count)) {
				$count++;
			}
		}
		return $haystack;
	}
}

if (!function_exists('mb_substr_replace')) {
	/**
	 * Replace text within a portion of a string.
	 *
	 * @param array $string The input string
	 * @param string $replacement The replacement string
	 * @param int $start If start is positive, the replacing will begin at
	 *  the start'th offset into string. If start is negative, the replacing
	 *  will begin at the start'th character from the end of string.
	 * @param int $length If given and is positive, it represents the length
	 *  of the portion of string which is to be replaced. If it is negative,
	 *  it represents the number of characters from the end of string at
	 *  which to stop replacing. If it is not given, then it will default to
	 *  strlen(string); i.e. end the replacing at the end of string. Of
	 *  course, if length is zero then this function will have the effect of
	 *  inserting replacement into string at the given start offset
	 * @param string $encoding
	 * @return mixed The result string is returned. If string is an array
	 *  then array is returned
	 */
	function mb_substr_replace($string, $replacement, $start, $length = null, $encoding = null) {
		$string_length = (is_null($encoding) === true) ? mb_strlen($string) : mb_strlen($string, $encoding);
		if ($start < 0) {
			$start = max(0, $string_length + $start);
		} else if ($start > $string_length) {
			$start = $string_length;
		}
		if ($length < 0) {
			$length = max(0, $string_length - $start + $length);
		} else if ((is_null($length) === true) || ($length > $string_length)) {
			$length = $string_length;
		}
		if (($start + $length) > $string_length) {
			$length = $string_length - $start;
		}
		if (is_null($encoding) === true) {
			return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length, $string_length - $start - $length);
		}
		return mb_substr($string, 0, $start, $encoding) . $replacement . mb_substr($string, $start + $length, $string_length - $start - $length, $encoding);
	}
}
