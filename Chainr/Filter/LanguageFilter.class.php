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

	private $defaultLanguage = null;

	public function __construct(array $options = array()) {
		parent::__construct(Chainr_Helper::getSimpleClassNameOf(__CLASS__));

		if (isset($options['languages'])) {
			$this->availableLanguages = $options['languages'];
		}

		if (isset($options['default_language'])) {
			$this->defaultLanguage = $options['default_language'];
		}
		else if(count($this->availableLanguages) > 0) {
			$this->defaultLanguage = reset($this->availableLanguages);
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
		} elseif (!is_null($this->defaultLanguage)) {
			$detectedLanguage = $this->defaultLanguage;
		}

		// Append current language
		if (!is_null($detectedLanguage) && $this->isAvailableLanguage($detectedLanguage)) {
			$node->appendTextNode('current_language', $detectedLanguage);
		}

		// Append available languages
		$availableLanguagesNode = $node->appendNode('available_languages');
		foreach($this->availableLanguages as $langKey => $langName) {
			$availableLanguagesNode->appendTextNode('language', $langName)->appendAttribute('key', $langKey);
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
		return array_key_exists($language, $this->availableLanguages);
	}

}

