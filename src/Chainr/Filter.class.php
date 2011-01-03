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
 * Base class for filters.
 *
 * @package Chainr
 *
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 **/
abstract class Chainr_Filter {
	private $id;

	private $context;

	public function __construct($id) {
		$this->id = $id;
	}

	/**
	 * Returns the id of the filter.
	 * 
	 * @return <type>
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Executes the filter.
	 * 
	 * @param Chainr_FilterChain $filterChain
	 * @return <type>
	 */
	final public function execute(Chainr_FilterChain $filterChain) {
		$stop = false;

		// Input processing goes here
		$methodName = 'executeInput';
		if (method_exists($this, $methodName) && is_callable(array($this, $methodName))) {
			$rootNode = $filterChain->getContext()->getDocument()->documentElement;
			$node = $rootNode->appendNode('filter')
	                       ->appendAttribute('id', lcfirst($this->getId()));

			$stop = call_user_func_array(array($this, $methodName), array(
				 $filterChain->getContext(), $node
			));
		}

		if ($stop === false) {
			// Execute the next filter at the chain
			if(($stop = $filterChain->execute()) === true) {
				return true;
			}
		}

		// Output processing goes here
		$methodName = 'executeOutput';
		if (method_exists($this, $methodName) && is_callable(array($this, $methodName))) {
			$stop = call_user_func_array(array($this, $methodName), array(
				 $filterChain->getContext()
			));
		}

		return $stop;
	}

	/**
	 * Initialize the filter
	 * 
	 * @param Chainr_Context $context
	 */
	public function init(Chainr_Context $context) {
		$this->context = $context;
	}

	/**
	 * Returns the current context.
	 *
	 * @return Chainr_Context
	 */
	public function getContext() {
		return $this->context;
	}
}