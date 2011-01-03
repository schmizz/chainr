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