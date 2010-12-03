<?php

/**
 * @package Chainr
 * @subpackage Filter
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Filter_RoutingFilter extends Chainr_Filter implements Chainr_InputFilter, Chainr_OutputFilter {

	private $redirectToHome = false;
	
	public function __construct() {
		parent::__construct(Chainr_Helper::getSimpleClassNameOf(__CLASS__));
	}
	
	public function executeOutput(Chainr_Context $context) {
		$response = $context->getResponse(); /* @var $response Chainr_Response */

		if ($this->redirectToHome) {
			$redirectTo = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/';
			
			$response->setHttpHeader('Location', $redirectTo, true);
			$response->setHttpStatusCode('301');
			$response->send();
		}

		return false;
	}

	public function executeInput(Chainr_Context $context, Chainr_ExtendedDOMElement $node) {
		$request = $context->getRequest();
		
		$path = isset($_GET['path']) ? $_GET['path'] : null;

		// @todo Make homepage configurable
		if ('home' == $path) {
			$this->redirectToHome = true;
			return true;
		}

		if (!is_null($path)) {
			if (strpos($path, '/') != false) {
				$segments = explode('/', $path);
			} else {
				$segments = array($path);
			}
		} else {
			$segments = array('home');
		}

		$segmentsNode = $node->appendNode('segments');
		foreach ($segments as $k => $v) {
			$segmentsNode->appendTextNode('segment', $v)
					       ->appendAttribute('id', $k);
		}

		$node->appendTextNode('page', $segments[0]);

		return false;
	}

}