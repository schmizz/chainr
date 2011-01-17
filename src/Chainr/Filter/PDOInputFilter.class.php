<?php

/**
 * This filter executes a query at a PDO compatible data source and renders
 * its results.
 * 
 * @package Chainr
 * @subpackage Filter
 * 
 * @author Christian Schmitz <csc@soulworks.de>
 * @copyright Copyright (c) 2010, Christian Schmitz, Soulworks GmbH
 */
class Chainr_Filter_PDOInputFilter extends Chainr_Filter implements Chainr_InputFilter {

	private $dsn;
	
	private $dbUser;
	private $dbPass;
	
	private $query;
	
	private $db;
	
	public function __construct(array $options = array()) {
		$id = isset($options['id'])
			? $options['id']
			: Chainr_Helper::getSimpleClassNameOf(__CLASS__);
		
		parent::__construct($id);
		
		if (isset($options['dsn'])) {
			$this->dsn = $options['dsn'];
		}

		if (isset($options['query'])) {
			$this->query = $options['query'];
		}

		if (isset($options['user'])) {
			$this->dbUser = $options['user'];
		}

		if (isset($options['pass'])) {
			$this->dbPass = $options['pass'];
		}
	}

	public function executeInput(Chainr_Context $context, Chainr_ExtendedDOMElement $node) {
		try {
			$this->db = new PDO($this->dsn, $this->dbUser, $this->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
			foreach ($this->db->query($this->query, PDO::FETCH_ASSOC) as $record) {
				$item = $node->appendNode('record');
				foreach ($record as $fieldName => $fieldValue) {
					$item->appendTextNode('field', $fieldValue)->appendAttribute('name', $fieldName);
				}
			}
		} catch(PDOException $e) {
			$node->appendTextNode('error', $e->getMessage());
		}
		
		return false;
	}
}