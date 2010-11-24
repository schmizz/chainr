<?php

/**
 * @package Chainr
 *
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Suspension {

	protected $siteXml;

	protected $filterChain = null;

	protected $context;

	private function __construct($siteXml) {
		$this->siteXml = $siteXml;
		$this->init();

	}

	/**
	 * Initializes the suspension.
	 */
	protected function init() {
		// Create a new DOM document with upgraded elements
		$doc = new DOMDocument('1.0', 'utf-8');
		$doc->registerNodeClass('DOMElement', 'Chainr_ExtendedDOMElement');
		$doc->xmlStandalone = true;

		// Load data to the document
		if ($doc->load($this->siteXml) === false) {
			throw new Chainr_Exception('Failed to load source XML: '.$this->siteXml);
		}

		// Check version of site's XML
		if (isset($doc->version) && $doc->version != '1.0') {
			throw new Chainr_Exception('Invalid chainr version at site\'s XML.');
		}

		// Prepare context
		$context = Chainr_Context::create()->init(new Chainr_Request(), new Chainr_Response(), Chainr_Session::getInstance());
		$context->setDocument($doc);

		$this->context = $context;

		// Initialize chains with context
		$this->filterChain = new Chainr_FilterChain($context);
	}

	/**
	 * Create a new suspension instance.
	 *
	 * @param <type> $siteXml
	 * @return Chainr_Suspension 
	 */
	public static function create($siteXml) {
		return new Chainr_Suspension($siteXml);
	}

	/**
	 * Register a new filter at the filter-chain
	 *
	 * @param Chainr_Filter_InputFilter $filter
	 */
	public function registerFilter(Chainr_Filter $filter) {
		$this->filterChain->register($filter);
	}

	/**
	 * Renders the chain and sends the contents.
	 * @param bool $send
	 * @return mixed
	 */
	public function render($send = true) {
		$this->filterChain->execute();

		$response = $this->context->getResponse();
		if ($send) {
			$response->send();
		} else {
			return $response;
		}
	}
}
