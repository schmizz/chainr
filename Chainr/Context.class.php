<?php

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
