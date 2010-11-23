<?php
/**
 * @package Chainr
 * @subpackage Filter
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Filter_LanguageFilter extends Chainr_Filter implements Chainr_InputFilter {
	private $language = null;

	private $availableLanguages = array();

	public function __construct(array $options = array()) {
		parent::__construct(Chainr_Helper::getSimpleClassNameOf(__CLASS__));

		if (isset($options['languages'])) {
			$this->availableLanguages = $options['languages'];
		}
	}

	public function executeInput(Chainr_Context $context, Chainr_ExtendedDOMElement $node) {
		$request = $context->getRequest(); /* @var $request Chainr_Request */
		$session = $context->getSession(); /* @var $session Chainr_Session */

		$detectedLanguage = null;

		// Switch language
		if (($language = $request->getParameter('language')) != null) {
			$detectedLanguage = $language;
		} elseif ($session->has('language')) {
			$detectedLanguage = $session->get('language');
		}

		// Determine current language
		if (!is_null($detectedLanguage) && $this->isAvailableLanguage($detectedLanguage)) {
			$node->appendTextNode('current_language', $detectedLanguage);
		}

		$session->set('language', $detectedLanguage);

		return false;
	}

	/**
	 * Check wether the given language is supported.
	 * 
	 * @param string $language
	 * @return bool
	 */
	protected function isAvailableLanguage($language) {
		return in_array($language, $this->availableLanguages);
	}

}

