<?php

/**
 * This filter dumps the XML source document. Just add ?dump=1 to the
 * request URI. This filter should never be used production, it's only
 * for debugging purposes.
 * 
 * @package Chainr
 * @subpackage Filter
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Filter_DumpFilter extends Chainr_Filter implements Chainr_OutputFilter, Chainr_InputFilter {
	protected $dump = false;
	
	private $paramName = 'dump';
	
	public function __construct(array $options = array()) {
		parent::__construct(Chainr_Helper::getSimpleClassNameOf(__CLASS__));
		
		if (isset($options['param_name'])) {
			$this->paramName = $options['param_name'];
		}
	}

	public function executeInput(Chainr_Context $context, Chainr_ExtendedDOMElement $node) {
		$request  = $context->getRequest(); /* @var $request Chainr_Request */

		$this->dump = $request->hasParameter($this->paramName);

		return false;
	}

	public function executeOutput(Chainr_Context $context) {
		$response = $context->getResponse(); /* @var $response Chainr_Response */

		// Dump source
		if ($this->dump) {
			// Resolve xincludes
			$doc = $context->getDocument();
			$doc->xinclude();

			// Output XML
			$response->setHttpHeader('Content-Type', 'application/xml');
			$response->setContent($doc->saveXML());

			// Stop chain
			return true;
		}
	}
}