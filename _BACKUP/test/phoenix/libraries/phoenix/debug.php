<?php

namespace Libraries\Phoenix;

class Debug
{
	public static function dump($data, $label = null) {
		echo '<pre>'.($label !== null ? $label.'&nbsp;' : '');
		if(is_array($data)) print_r($data);
		else echo $data;
		echo '</pre>';
	}
}