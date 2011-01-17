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
 * Chainr main-class
 *
 * @package Chainr
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 **/
class Chainr {

	/**
	 * @var string
	 */
	protected static $path = '';

	/**
	 * Array of all classes of the Base package. It is used by the autoloader.
	 * @var array
	 */
	protected static $autoloads = array(
		'Chainr_Exception'     => 'Chainr/Exception.class.php',
		'Chainr_Exception_XslLoadException'    => 'Chainr/Exception/XslLoadException.class.php',
		'Chainr_Helper'        => 'Chainr/Helper.class.php',
		'Chainr_Context'       => 'Chainr/Context.class.php',
		'Chainr_FilterChain'   => 'Chainr/FilterChain.class.php',
		'Chainr_Filter'        => 'Chainr/Filter.class.php',
		'Chainr_InputFilter'   => 'Chainr/InputFilter.interface.php',
		'Chainr_OutputFilter'  => 'Chainr/OutputFilter.interface.php',
		'Chainr_Filter_CacheFilter'            => 'Chainr/Filter/CacheFilter.class.php',
		'Chainr_Filter_DumpFilter'             => 'Chainr/Filter/DumpFilter.class.php',
		'Chainr_Filter_LanguageFilter'         => 'Chainr/Filter/LanguageFilter.class.php',
		'Chainr_Filter_RequestDataFilter'      => 'Chainr/Filter/RequestDataFilter.class.php',
		'Chainr_Filter_RoutingFilter'          => 'Chainr/Filter/RoutingFilter.class.php',
		'Chainr_Filter_HtmlRenderFilter'       => 'Chainr/Filter/HtmlRenderFilter.class.php',
		'Chainr_Filter_PDOInputFilter'         => 'Chainr/Filter/PDOInputFilter.class.php',
		'Chainr_Suspension'         => 'Chainr/Suspension.class.php',
		'Chainr_ExtendedDOMElement' => 'Chainr/ExtendedDOMElement.class.php',
		'Chainr_Request'            => 'Chainr/Request.class.php',
		'Chainr_Response'           => 'Chainr/Response.class.php',
		'Chainr_Session'            => 'Chainr/Session.class.php',
	);

	/**
	 * This method serves as a class loader for all classes of the
	 * Base package.
	 * 
	 * @param <type> $className 
	 */
	public static function autoload($className) {
		if(isset(self::$autoloads[$className])) {
			require(self::$path . '/' . self::$autoloads[$className]);
		}
	}

	/**
	 * This methods bootstraps the Base class. Therefore it will register the
	 * autoloader and a default error handler.
	 */
	public static function bootstrap() {
		self::$path = dirname(__FILE__);
		spl_autoload_register(array('Chainr', 'autoload'));

		// Set default error handler so we'll get exceptions
		set_error_handler(array('Chainr', 'handleError'), E_ALL);
	}

	/**
	 * This methods is used as default error handler, which throws
	 * nice to handle exceptions.
	 *
	 * @author Christian Schmitz <csc@soulworks.de>
	 * 
	 * @param <type> $code
	 * @param <type> $string
	 * @param <type> $file
	 * @param <type> $line
	 * @param <type> $context 
	 * @return void
	 */
	public static function handleError($code, $string, $file, $line, $context) {
		throw new Chainr_Exception($string, $code);
	}

	/**
	 *
	 * @param <type> $siteXml
	 * @return Chainr_Suspension
	 */
	public static function createSuspension($siteXml) {
		return Chainr_Suspension::create($siteXml);
	}

	/**
	 * Prettifies the given exception.
	 *
	 * @param Exception $e Exception to be prettified.
	 */
	public static function prettifyException(Exception $e) {
		$out = '';
		foreach ($e->getTrace() as $item) {
			$class = isset($item['class']) ? $item['class'] : 'n/a';
			$type  = isset($item['type'])  ? $item['type']  : 'n/a';

			$out .= sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>'."\n", $class, $type, $item['function']);
		}
		$out = '<html><head><title>chainr exception</title></head><body><pre>Chainr Ausnahme gefangen: '.$e->getMessage().'<table>'.$out.'</table></pre></body></html>';
		
		echo $out;
	}
}
