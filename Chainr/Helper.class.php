<?php

/**
 * @package Chainr
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Helper {
	/**
	 * Returns a simple version of a Chainr's class name.
	 * 
	 * @param string $className
	 * @return string
	 */
	public static function getSimpleClassNameOf($className) {
		$tokens = explode('_', $className);
		return array_pop($tokens);
	}
}