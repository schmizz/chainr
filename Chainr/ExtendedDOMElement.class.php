<?php

/**
 * The ExtendedDOMElement is an improved version of a DOMElement
 * with some shortcuts to the most used features.
 *
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_ExtendedDOMElement extends DOMElement {
	/**
	 * Appends a node.
	 * 
	 * @param string $name
	 * @return Chainr_ExtendedDOMElement
	 */
	public function appendNode($name) {
		$elementNode = $this->getDocument()->createElement($name);
		$this->appendChild($elementNode);
		return $elementNode;
	}

	/**
	 * Appends a node and a textnode at once.
	 * 
	 * @param string $name
	 * @param string $value
	 * @param array $options
	 * @return Chainr_ExtendedDOMElement
	 */
	public function appendTextNode($name, $value, $options = array()) {
		$elementNode = $this->appendNode($name);

		if(array_key_exists('cdata', $options)) {
			$textNode = $this->getDocument()->createCDATASection($value);
		}
		else {
			$textNode = $this->getDocument()->createTextNode($value);
		}
		$elementNode->appendChild($textNode);

		return $elementNode;
	}

	/**
	 * Appends a comment.
	 * 
	 * @param string $comment
	 * @return Chainr_ExtendedDOMElement
	 */
	public function appendCommentNode($comment) {
		$commentNode = $this->getDocument()->createComment($comment);
		$this->appendChild($commentNode);
		return $commentNode;
	}

	/**
	 * Appends an attribute.
	 * 
	 * @param string $name
	 * @param string $value
	 * @return Chainr_ExtendedDOMElement
	 */
	public function appendAttribute($name, $value) {
		// Create the nodes
		$attributeNode = $this->getDocument()->createAttribute($name);
		$this->appendChild($attributeNode);

		$textNode = $this->getDocument()->createTextNode($value);
		$attributeNode->appendChild($textNode);

		return $this;
	}

	/**
	 * Returns the owning document of the node.
	 * 
	 * @return DOMDocument
	 */
	protected function getDocument() {
		return $this->ownerDocument;
	}
}
