<?php

/**
 * @package Chainr
 * @subpackage Filter
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Filter_HtmlRenderFilter extends Chainr_Filter implements Chainr_OutputFilter {
	private $pagesDir;

	public function __construct(array $options = array()) {
		parent::__construct(Chainr_Helper::getSimpleClassNameOf(__CLASS__));

		$this->pagesDir = isset($options['pages_dir'])
			? $options['pages_dir']
			: './pages/';
	}


	public function executeOutput(Chainr_Context $context) {
		$response = $context->getResponse(); /* @var $response Chainr_Response */
		
		$doc = $context->getDocument();
		$doc->xinclude();

		// Import the DOM document at SimpleXml
		$sxl = simplexml_import_dom($doc);

		// Pick up the page
		$page = $sxl->xpath('//filter[@id=\'routingFilter\']//segment[@id=\'0\']');
		if (is_array($page) && count($page) > 0) {
			$page = (string)array_shift($page);
		}

		// Append suffix to filename
		$template = $this->pagesDir . $page . '.xsl';

		// Trap 404
		if (!file_exists($template) || !is_readable($template)) {
			$response->setHttpStatusCode('404');
			$template = $this->pagesDir . '_404.xsl';
		}
		    
		// Create a processor
		$xsltp = new XSLTProcessor();

		// Put some parameters at the processor
		foreach ($sxl->xpath('//filter[@id=\'requestDataFilter\']/environment/parameter') as $param) {
			$xsltp->setParameter('', $param->attributes()->name, (string)$param);
		}
		$xsltp->setParameter('', 'page', $page);

		// Loading XSLT site
		$xsl = new DOMDocument();
		$xsl->substituteEntities = true;
		if (@$xsl->load($template) === false) {
		    throw new Chainr_Exception_XslLoadException('Failed to load XSLT file '.$template);
		}

		// Attach stylestheet
		$xsltp->importStyleSheet($xsl);

		// Transform the document
		$output = $xsltp->transformToXML($doc); // transforming

		// Put output at the context
		$response->setContent($output);

		return false;
	}
}