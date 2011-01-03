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
class Chainr_FilterChain {

	protected $chain = array();

	protected $index = -1;

	/**
	 * The current context.
	 * 
	 * @var Chainr_Context
	 */
	protected $context = null;

	/**
	 * Constructs a new filter chain.
	 * 
	 * @param Chainr_Context $context
	 */
	public function __construct(Chainr_Context $context) {
		$this->context = $context;
	}

	/**
	 * Registers the filter at the filter chain
	 * 
	 * @param Chainr_Filter $filter
	 */
	public function register(Chainr_Filter $filter) {
		// Check wether the filter is already registered
		foreach ($this->chain as &$f) {
			if ($f->getId() == $filter->getId()) {
				throw new Chainr_Exception('A filter with that id ('.$filter->getId().') is already at the chain.');
			}
		}

		// Initialize the filter
		$filter->init($this->getContext());

		// Put the filter at the chain
		$this->chain[] = $filter;
	}

	/**
	 * Returns the current context.
	 * 
	 * @return Chainr_Context
	 */
	public function getContext() {
		return $this->context;
	}

	/**
	 * Executes the next filter at the chain.
	 */
	public function execute() {
		if (($filter = $this->getNext()) != null) {
			return $filter->execute($this);
		}
	}

	/**
	 * Retrieves the next filter at the chain.
	 * 
	 * @return Chainr_Filter
	 */
	protected function getNext() {
		$this->index++;
		if($this->index < count($this->chain)) {
			return $this->chain[$this->index];
		}
	}

	/**
	 * Checks wether there are any filters at the chain.
	 * @return <type>
	 */
	public function isEmpty() {
		return empty($this->chain);
	}
}