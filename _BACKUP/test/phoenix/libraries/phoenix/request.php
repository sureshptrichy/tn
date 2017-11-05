<?php

namespace Libraries\Phoenix;

class Request extends Singleton
{
	private $_rawRequest = null;
	private $_requestVars = array();

	protected function __construct()
	{
		$rawRequest = $_SERVER['REQUEST_URI'];
		if(empty($rawRequest)) $requestVars = array();
		else
		{
			$rawRequest = explode('?', $rawRequest);
			$requestVars = explode('/', trim($rawRequest[0], '/'));
		}
		$this->_rawRequest = $rawRequest;
		$this->_requestVars = $requestVars;
	}

	public function getRawRequest()
	{
		return $this->_rawRequest;
	}

	public function getRequestVars()
	{
		return $this->_requestVars;
	}
}