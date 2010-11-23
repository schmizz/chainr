<?php

/**
 * A simple session-wrapper
 *
 * @package Chainr
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Session {
	
	private function  __construct() {
		// Start session
		session_start();
	}

	public static function getInstance() {
		static $instance;
		if (!is_object($instance)) {
			$instance = new Chainr_Session();
		}
		return $instance;
	}

	/**
	 * Checks wether the given name exists at the session.
	 *
	 * @param string $name
	 * @return bool
	 */
	public function has($name) {
		return isset($_SESSION[$name]);
	}

	/**
	 * Returns the value namen <code>$name</code> stored at the
	 * current session.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function get($name) {
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	/**
	 * Sets the value of <code>$name</code> at the current session.
	 *
	 * @param <type> $name
	 * @param <type> $value
	 */
	public function set($name, $value) {
		if (is_null($value)) {
			unset($_SESSION[$name]);
		} else {
			$_SESSION[$name] = $value;
		}
	}
}