<?php

/**
 * @package Chainr
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Response {
	private $content = '';

	private $httpHeaders = array();

	private $httpStatusCode = '200';

	private $cookies = array();

	protected $http10StatusCodes = array(
		'200' => "HTTP/1.0 200 OK",
		'201' => "HTTP/1.0 201 Created",
		'202' => "HTTP/1.0 202 Accepted",
		'204' => "HTTP/1.0 204 No Content",
		'205' => "HTTP/1.0 205 Reset Content",
		'206' => "HTTP/1.0 206 Partial Content",
		'300' => "HTTP/1.0 300 Multiple Choices",
		'301' => "HTTP/1.0 301 Moved Permanently",
		'302' => "HTTP/1.0 302 Found",
		'304' => "HTTP/1.0 304 Not Modified",
		'400' => "HTTP/1.0 400 Bad Request",
		'401' => "HTTP/1.0 401 Unauthorized",
		'402' => "HTTP/1.0 402 Payment Required",
		'403' => "HTTP/1.0 403 Forbidden",
		'404' => "HTTP/1.0 404 Not Found",
		'405' => "HTTP/1.0 405 Method Not Allowed",
		'406' => "HTTP/1.0 406 Not Acceptable",
		'407' => "HTTP/1.0 407 Proxy Authentication Required",
		'408' => "HTTP/1.0 408 Request Timeout",
		'409' => "HTTP/1.0 409 Conflict",
		'410' => "HTTP/1.0 410 Gone",
		'411' => "HTTP/1.0 411 Length Required",
		'412' => "HTTP/1.0 412 Precondition Failed",
		'413' => "HTTP/1.0 413 Request Entity Too Large",
		'414' => "HTTP/1.0 414 Request-URI Too Long",
		'415' => "HTTP/1.0 415 Unsupported Media Type",
		'416' => "HTTP/1.0 416 Requested Range Not Satisfiable",
		'417' => "HTTP/1.0 417 Expectation Failed",
		'500' => "HTTP/1.0 500 Internal Server Error",
		'501' => "HTTP/1.0 501 Not Implemented",
		'502' => "HTTP/1.0 502 Bad Gateway",
		'503' => "HTTP/1.0 503 Service Unavailable",
		'504' => "HTTP/1.0 504 Gateway Timeout",
		'505' => "HTTP/1.0 505 HTTP Version Not Supported",
	);

	protected $http11StatusCodes = array(
		'100' => "HTTP/1.1 100 Continue",
		'101' => "HTTP/1.1 101 Switching Protocols",
		'200' => "HTTP/1.1 200 OK",
		'201' => "HTTP/1.1 201 Created",
		'202' => "HTTP/1.1 202 Accepted",
		'203' => "HTTP/1.1 203 Non-Authoritative Information",
		'204' => "HTTP/1.1 204 No Content",
		'205' => "HTTP/1.1 205 Reset Content",
		'206' => "HTTP/1.1 206 Partial Content",
		'300' => "HTTP/1.1 300 Multiple Choices",
		'301' => "HTTP/1.1 301 Moved Permanently",
		'302' => "HTTP/1.1 302 Found",
		'303' => "HTTP/1.1 303 See Other",
		'304' => "HTTP/1.1 304 Not Modified",
		'305' => "HTTP/1.1 305 Use Proxy",
		'307' => "HTTP/1.1 307 Temporary Redirect",
		'400' => "HTTP/1.1 400 Bad Request",
		'401' => "HTTP/1.1 401 Unauthorized",
		'402' => "HTTP/1.1 402 Payment Required",
		'403' => "HTTP/1.1 403 Forbidden",
		'404' => "HTTP/1.1 404 Not Found",
		'405' => "HTTP/1.1 405 Method Not Allowed",
		'406' => "HTTP/1.1 406 Not Acceptable",
		'407' => "HTTP/1.1 407 Proxy Authentication Required",
		'408' => "HTTP/1.1 408 Request Timeout",
		'409' => "HTTP/1.1 409 Conflict",
		'410' => "HTTP/1.1 410 Gone",
		'411' => "HTTP/1.1 411 Length Required",
		'412' => "HTTP/1.1 412 Precondition Failed",
		'413' => "HTTP/1.1 413 Request Entity Too Large",
		'414' => "HTTP/1.1 414 Request-URI Too Long",
		'415' => "HTTP/1.1 415 Unsupported Media Type",
		'416' => "HTTP/1.1 416 Requested Range Not Satisfiable",
		'417' => "HTTP/1.1 417 Expectation Failed",
		'500' => "HTTP/1.1 500 Internal Server Error",
		'501' => "HTTP/1.1 501 Not Implemented",
		'502' => "HTTP/1.1 502 Bad Gateway",
		'503' => "HTTP/1.1 503 Service Unavailable",
		'504' => "HTTP/1.1 504 Gateway Timeout",
		'505' => "HTTP/1.1 505 HTTP Version Not Supported",
	);

	public function getContent() {
		return $this->content;
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function getContentLength() {
		return strlen($this->content);
	}

	public function getHttpHeaders() {
		return $this->httpHeaders;
	}

	public function setHttpHeaders(array $headers) {
		foreach ($headers as $name => $value) {
			$this->setHttpHeader($name, $value);
		}
	}

	public function setHttpHeader($name, $value, $replace = true) {
		if (!isset($this->httpHeaders[$name]) || $replace) {
			$this->httpHeaders[$name] = $value;
		}
	}

	public function getHttpHeader($name) {
		return isset($this->httpHeaders[$name]) ? $this->httpHeaders[$name] : null;
	}

	public function isValidHttpStatusCode($code) {
		$code = (string)$code;
		return isset($this->http11StatusCodes[$code]);
	}

	public function setHttpStatusCode($code) {
		if (!$this->isValidHttpStatusCode($code)) {
			throw new Chainr_Exception('Invalid HTTP status code: '.$code);
		}
		$this->httpStatusCode = $code;
	}

	public function getHttpStatusCode() {
		return $this->httpStatusCode;
	}

	public function setCookie($name, $value, $lifetime = null, $path = null, $domain = null, $secure = null, $httponly = null) {
		$cookie = array(
			'value'  => $value,
			'domain' => $domain,
			'path'   => $path,
		);

		$cookie['lifetime'] = !is_null($lifetime) ? $lifetime : 0;
		$cookie['secure']   = !is_null($secure) ? (bool)$secure : false;
		$cookie['httponly'] = !is_null($httponly) ? (bool)$httponly : false;

		$this->cookies[$name] = $cookie;
	}

	public function unsetCookie($name, $path = null, $domain = null, $secure = null, $httponly = null)	{
		// false as the value, triggers deletion
		// null for the lifetime, since Agavi automatically sets that when the value is false or null
		$this->setCookie($name, false, null, $path, $domain, $secure, $httponly);
	}

	public function hasCookie($name)	{
		return isset($this->cookies[$name]);
	}

	public function getCookie($name) {
		if (isset($this->cookies[$name])) {
			return $this->cookies[$name];
		}
	}

	public function removeCookie($name) {
		if (isset($this->cookies[$name])) {
			unset($this->cookies[$name]);
		}
	}

	public function getCookies() {
		return $this->cookies;
	}

	public function sendHeaders() {
		// Send HTTP status code
		if(($httpStatusCode = $this->getHttpStatusCode()) != null) {
			header($httpStatusCode);
		}

		$this->setHttpHeader('X-Powered-By', 'me');

		foreach ($this->getHttpHeaders() as $name => $value) {
			if (!is_null($value)) {
				header($name . ': ' . $value);
			}
		}
	}
	
	public function sendContent() {
		echo $this->getContent();
	}

	public function send() {
		// Send cookies
		foreach($this->getCookies() as $name => $values) {
			if(is_string($values['lifetime'])) {
				// a string, so we pass it to strtotime()
				$expire = strtotime($values['lifetime']);
			} else {
				// do we want to set expiration time or not?
				$expire = ($values['lifetime'] != 0) ? time() + $values['lifetime'] : 0;
			}

			if($values['value'] === false || $values['value'] === null || $values['value'] === '') {
				$expire = time() - 3600 * 24;
			}

			setcookie($name, $values['value'], $expire, $values['path'], $values['domain'], $values['secure'], $values['httponly']);
		}
		
		$this->sendHeaders();
		$this->sendContent();
	}
}