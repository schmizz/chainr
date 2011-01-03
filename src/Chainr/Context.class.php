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
 * The <code>Chainr_Context</code> provides information about the current 
 * context of the application. It glues the core elements of the application
 * together.
 *
 * @package Chainr
 *
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 **/
class Chainr_Context {

	/**
	 * @var Chainr_Session
	 */
	protected $session;

	/**
	 * @var Chainr_Request
	 */
	protected $request;

	/**
	 * @var Chainr_Response
	 */
	protected $response;

	/**
	 * @var DOMDocument
	 */
	protected $doc;

	private function  __construct() {
		;
	}

	public static function create() {
		return new Chainr_Context();
	}

	public function init(Chainr_Request $request, Chainr_Response $response, Chainr_Session $session) {
		$this->request = $request;
		$this->response = $response;
		$this->session = $session;
		return $this;
	}

	/**
	 * Returns the context's session
	 * 
	 * @return Chainr_Session
	 */
	public function getSession() {
		return $this->session;
	}

	/**
	 * Returns the context's request
	 *
	 * @return Chainr_Request
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Returns the context's response
	 *
	 * @return Chainr_Response
	 */
	public function getResponse() {
		return $this->response;
	}

	/**
	 *
	 * @return DOMDocument
	 */
	public function getDocument() {
		return $this->doc;
	}

	/**
	 *
	 * @param DOMDocument $doc 
	 */
	public function setDocument(DOMDocument $doc) {
		$this->doc = $doc;
		return $this;
	}

}
