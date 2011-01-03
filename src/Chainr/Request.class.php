<?php

/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @package Chainr
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Request {
	const METHOD_GET    = 'get';
	const METHOD_POST   = 'post';
	const METHOD_PUT    = 'put';
	const METHOD_DELETE = 'delete';

	private $method = null;

	private $supportedMethods = array();

	private $headers = array();

	/**
	 * Constructs a new request.
	 */
	public function __construct() {
		$this->supportedMethods = array(self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE);

		if (function_exists('apache_request_headers')) {
			foreach (apache_request_headers() as $name => $value) {
				$this->headers[$name] = $value;
			}
		} else {
			foreach($_SERVER as $name => $value) {
				if (substr($name, 0, 5) == 'HTTP_') {
					$name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
				}
				$this->headers[$name] = $value;
			}
		}

		// Determine request method
		$this->setMethod(strtolower($_SERVER['REQUEST_METHOD']));
	}

	/**
	 * Checks wether the given method is supported.
	 *
	 * @param string $method
	 * @return bool
	 */
	protected function isSupportedHttpMethod($method) {
		return in_array($method, $this->supportedMethods);
	}

	/**
	 * Checks wether the current request is an AJAX request.
	 * 
	 * @return bool
	 */
	public function isAjax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	/**
	 * Returns the current method of the request.
	 *
	 * @return <type>
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * Sets the method of the request.
	 * 
	 * @param <type> $method
	 */
	protected function setMethod($method) {
		if (!$this->isSupportedHttpMethod($method)) {
			throw new Chainr_Exception('Unsupported method: '. $method);
		}
		$this->method = $method;
	}

	/**
	 * Returns a single header by its name.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function getHeader($name) {
		return isset($this->headers[$name]) ? $this->headers[$name] : null;
	}

	/**
	 * Returns all headers.
	 * 
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}

	/**
	 * Returns a request parameter by its name.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function getParameter($name) {
		return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
	}

	/**
	 * Returns the names of all available request parameters.
	 *
	 * @return array
	 */
	public function getParameterNames() {
		return array_keys($_REQUEST);
	}

	/**
	 * Checks the request for a parameter.
	 *
	 * @param string $name
	 * @return bool
	 */
	public function hasParameter($name) {
		return isset($_REQUEST[$name]);
	}
}