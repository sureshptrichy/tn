<?php

namespace Libraries\Phoenix;

class Singleton
{
	protected static $_instance = null;
	
	private function __clone() {}
	private function __wakeup() {}
	private function __construct() {}
	
	final public static function getInstance()
	{
		$class = __CLASS__;
		if(self::$_instance === null) self::$_instance = new static();
		return static::$_instance;
	}
}