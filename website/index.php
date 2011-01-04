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

// Enable strict error reporting
error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', 1);

if (false === function_exists('lcfirst')):
	function lcfirst( $str ) { return (string)(strtolower(substr($str,0,1)).substr($str,1)); }
endif;

require('Chainr.class.php');

// Bootstrap Chainr
Chainr::bootstrap();

try {
	// Create a suspension from the site's source
	$site = Chainr::createSuspension('./chainr.xml');

	// Attach filters
	/*
	$site->registerFilter(new Chainr_Filter_CacheFilter(array(
	    'cache_dir' => './_cache/',
		'ttl'       => 3600
	)));*/
	$site->registerFilter(new Chainr_Filter_HtmlRenderFilter(array(
	    'pages_dir' => './_pages/'
	)));
	$site->registerFilter(new Chainr_Filter_DumpFilter());
	$site->registerFilter(new Chainr_Filter_LanguageFilter(array(
		 'languages'        => array('de' => 'Deutsch', 'en' => 'English'),
		 'default_language' => 'de'
	)));
	$site->registerFilter(new Chainr_Filter_RequestDataFilter());
	$site->registerFilter(new Chainr_Filter_RoutingFilter());

	$site->render();
} catch(Chainr_Exception $e) {
	Chainr::prettifyException($e);
} catch(Exception $e) {
	Chainr::prettifyException($e);
}

?>