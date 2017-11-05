<?php

namespace Libraries\Phoenix;

class Autoload
{
	public static function loadClass($class)
	{
		$class = str_replace('\\', '/', strtolower($class));
		$classFile = PHOENIX_ROOT.'/'.$class.'.php';
		echo 'Loading: '.$classFile.'<br>';
		if(file_exists($classFile))	require_once($classFile);
	}
}

spl_autoload_register(__NAMESPACE__.'\Autoload::loadClass');
