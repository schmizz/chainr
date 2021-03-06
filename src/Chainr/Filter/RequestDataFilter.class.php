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
 * This filter appends all get- and cookie-parameters to the site's source.
 * 
 * @package Chainr
 * @subpackage Filter
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Filter_RequestDataFilter extends Chainr_Filter implements Chainr_InputFilter {

	public function __construct() {
		parent::__construct(Chainr_Helper::getSimpleClassNameOf(__CLASS__));
	}

	public function executeInput(Chainr_Context $context, Chainr_ExtendedDOMElement $node) {

		// Append GET parameters
		if (is_array($_GET) && count($_GET) > 0) {
			$ps = $node->appendNode('parameters')->appendAttribute('method', 'get');
			foreach($_GET as $k => $v) {
				$ps->appendTextNode('parameter', $v)->appendAttribute('name', $k);
			}
		}

		if (is_array($_COOKIE) && count($_COOKIE) > 0) {
			$ps = $node->appendNode('parameters')->appendAttribute('method', 'cookie');
			foreach($_COOKIE as $k => $v) {
				$ps->appendTextNode('parameter', $v)->appendAttribute('name', $k);
			}
		}

		return false;
	}
}