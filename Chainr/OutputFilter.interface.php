<?php

/**
 * @package Chainr
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
interface Chainr_OutputFilter {
	public function executeOutput(Chainr_Context $context);
}