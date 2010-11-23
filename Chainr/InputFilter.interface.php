<?php

/**
 * @package Chainr
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
interface Chainr_InputFilter {
	public function executeInput(Chainr_Context $context, Chainr_ExtendedDOMElement $node);
}