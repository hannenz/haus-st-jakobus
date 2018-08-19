<?php
namespace Jakobus;

use Contentomat\DBCex;
use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Debug;
use Contentomat\FieldHandler;
use Contentomat\Parser;
use \Exception;

class Model {
	
	/**
	 * @var Object
	 */
	protected $db;

	/**
	 * Contentomat Object instance
	 * @var Object
	 */
	protected $cmt;

	/**
	 * @var Object
	 */
	protected $PsrAutoloader;

	/**
	 * @var String
	 */
	protected $tableName;

	/**
	 * @var Array
	 */
	protected $fields;

	/**
	 * @var Array
	 */
	protected $filter;

	/**
	 * @var Array
	 */
	protected $order;

	/**
	 * @var Int
	 */
	protected $limit;

	/**
	 * @var string
	 */
	protected $language;


	/**
	 * @var Array
	 */
	protected $belongsTo = [];

	/**
	 * @var Array
	 */
	protected $hasOne = [];

	/**
	 * @var Array
	 */
	protected $hasMany = [];


	/**
	 * @var Object
	 */
	protected $FieldHandler;

	/**
	 * @var Object
	 */
	protected $Parser;

	/**
	 * @var Array;
	 */
	protected $validationErrors = [];

	/**
	 * @var Array
	 */
	protected $validationRules = [];

	public function __construct () {
		$this->db = new DBCex ();
		$this->cmt = Contentomat::getContentomat ();
		$this->PsrAutoloader = new PsrAutoloader ();
		$this->Parser = new Parser ();
		$this->FieldHandler = new FieldHandler ();
		$this->fields = [];
		$this->filter = [];
		$this->order = [];
		$this->limit = -1;
		// $this->belongsTo = [];
		// $this->hasMany = [];

		$this->init ();
	}



	public function init () {
	}



	/**
	 * Setter for `language`
	 *
	 * @access public
	 * @param string 			The language to use, defaults to 'de'
	 * @return void
	 */
	public function setLanguage ($language = 'de') {
		$this->language = $language;
	}



	/**
	 * Setter for `tableName`
	 *
	 * @access public
	 * @param string 			The mysql table name
	 * @return void
	 */
	public function setTableName ($tableName) {
		$this->tableName = $tableName;
	}



	public function order ($order = []) {
		$this->order = $order;
		return $this;
	}



	public function filter ($filter = []) {
		$this->filter = $filter;
		return $this;
	}



	public function limit ($limit = -1) {
		$this->limit = $limit;
		return $this;
	}



	public function fields ($fields = []) {
		$this->fields = $fields;
		return $this;
	}



	/**
	 * findAll
	 *
	 * apply all filters and options and fetch all records
	 *
	 * @access public
	 * @param Array 		Options
	 * @return Array
	 * @throws Exception
	 *
	 * Available Options
	 * - fetchAssociations 		Boolean 	Whether to fetch asscoiated records too
	 */
	public function findAll ($options = []) {

		$options = array_merge ([
			'fetchAssociations' => true
		], $options);

		$query = sprintf ("SELECT %s FROM %s %s %s %s",
			empty ($this->fields) ? "*" : join (',', $this->fields),
			$this->tableName,
			empty ($this->filter) ? "" : "WHERE " . $this->getFilterString (),
			empty ($this->order) ? "" : "ORDER BY " . $this->getOrderString (),
			$this->limit == -1 ? "" : sprintf ("LIMIT %u", $this->limit)
		);
		if ($this->db->query ($query) != 0) {
			throw new Exception ("Query failed: " . $query);
		}
		$results = $this->db->getAll ();

		if ($options['fetchAssociations']) {
			foreach ($results as &$result) {
				$result = $this->fetchAssociations ($result);
			}
		}

		return $this->afterRead ($results);
	}



	/**
	 * findOne
	 *
	 * apply all filters and options and fetch one record
	 *
	 * @access public
	 * @param Array 		Options
	 * @return Array 		The record's data
	 * @throws Exception
	 *
	 * Available Options
	 * - fetchAssociations 		Boolean 	Whether to fetch asscoiated records too
	 */
	public function findOne ($options = []) {

		$options = array_merge ([
			'fetchAssociations' => true
		], $options);

		$query = sprintf ("SELECT %s FROM %s %s %s LIMIT 1",
			empty ($this->fields) ? "*" : join (',', $this->fields),
			$this->tableName,
			empty ($this->filter) ? "" : "WHERE " . $this->getFilterString (),
			empty ($this->order) ? "" : "ORDER BY " . $this->getOrderString ()
		);
		if ($this->db->query ($query) != 0) {
			throw new Exception ("Query failed: " . $query);
		}

		$results = $this->db->getAll ();
		if (count ($results) > 0)  {
			$results = $this->afterRead ($results);
			return array_shift($results);
		}
		else {
			return null;
		}
	}



	/**
	 * A filter is passed like this:
	 * [
	 *     'operand1' => $operand2,
	 * ]
	 */
	private function getFilterString () {

		$strings = [];

		foreach ($this->filter as $operand1 => $operand2) {
			$operator = '=';
			if (preg_match ('/^(.*)\s+([\=\!\>\<\%])\s+$/', $operand1, $matches)) {
				$operand1 = $matches[1];
				$operator = $matches[2];
			}
			$strings[] = sprintf ('%s %s %s', $operand1, $operator, $operand2);
		}

		return join (' AND ', $strings);
	}



	/**
	 * An order is passed like this:
	 * [
	 *     'field' => 'direction',
	 * ]
	 */
	private function getOrderString () {

		$strings = [];

		foreach ($this->order as $field => $direction) {
			switch (strtolower ($direction)) {
				case '<':
				case 'd':
				case 'desc':
					$direction = 'DESC';
					break;
				case '>':
				case 'a':
				case 'asc':
					$direction = 'ASC';
					break;
			}

			$strings[] = sprintf ('%s %s', $field, $direction);
		}

		return join (',', $strings);
	}

	protected function afterRead ($results) {
		return $results;
	}

	/**
	 * Fetch the associations of that model for a given record
	 *
	 * @param Array
	 * @param Boolean 			$merge: Default: true. Whether to merge the associations into tje
	 * 							results array or create a subarray for each association
	 * @return Array
	 */ 			
	protected function fetchAssociations ($result, $merge = true) {

		foreach ((array)$this->belongsTo as $assoc) {

			$className = $assoc['className'];

			$this->PsrAutoloader->loadClass ($className);
			$instance = new $className ();

			$assocData = $instance
				->filter([
					$assoc['foreignKey'] => $result[$assoc['foreignKeyField']]
				])
				->findOne ([
					'fetchAssociations' => false
				])
			;
			if ($merge) {
				$result = array_merge ($result, $assocData);
			}
			else {
				$result[$assoc['name']] = $assocData;
			}
		}

		foreach ((array)$this->hasOne as $assoc) {


		}

		foreach ((array)$this->hasMany as $assoc) {

			$className = $assoc['className'];

			$this->PsrAutoloader->loadClass ($className);
			$instance = new $className ();

			$assocData = $instance
				->filter([
					$assoc['foreignKeyField'] => $result[$assoc['foreignKey']]
				])
				->findAll ([
					'fetchAssociations' => false
				])
			;

			$result[$assoc['name']] = $assocData;
		}

		return $result;
	}



	/**
	 * Getter for validationErrors
	 *
	 * @return Array 
	 */
	public function getValidationErrors () {
		return $this->validationErrors;
	}



	/**
	 * Setter for validationRules
	 *
	 * @param Array
	 * @return void
	 */
	public function setValidationRules ($validationRules) {
		$this->validationRules = $validationRules;
	}



	/**
	 * Getter for validationRules
	 *
	 * @return Array 
	 */
	public function getValidationRules () {
		return $this->validationRules;
	}


	/**
	 * Validate
	 *
	 * @param Array The data to validate
	 * @return boolean
	 */
	public function validate ($data) {

		$this->validationErrors = [];

		foreach ((array)$this->validationRules as $field => $rules) {

			if (!isset ($data[$field])) {
				$this->validationErrors[$field] = [ "Missing field: $field" ];
				continue;
			}

			$value = $data[$field];

			foreach ((array)$rules as $rule) {
				if (method_exists (getClass ($this), $rule)) {
					$result = call_user_func ([__NAMESPACE__ . '\\' . getClass(), $data[$field]]);
				}
				else {
					$result = preg_match ($rule, $data[$field]);
				}

				if (!$result) {
					$this->validationErrors[$field][] = true;

				}
			}	
		}

		return (empty ($this->validationErrors));
	}


	public function getFormField ($fieldName, $params = []) {

		$fieldData = $this->FieldHandler->getField ([
			'tableName' => $this->tableName,
			'fieldName' => $fieldName
		]);

		$defaultParams = [
			'label' => $fieldData['cmt_fieldalias'],
			'value' => $_POST[$fieldName],
			'required' => false
		];
		$params = array_merge ($defaultParams, $params);

		$this->Parser->setMultipleParserVars ($fieldData);
		$this->Parser->setParserVar ('fieldName', $fieldName);
		$this->Parser->setParserVar ('fieldValue', $params['value']);
		$this->Parser->setParserVar ('fieldLabel', $params['label']);
		$this->Parser->setParserVar ('required', $params['required']);

		if ($fieldData['cmt_fieldtype'] == 'select') {
			$_options = [];
			$options = split("\n", $fieldData['cmt_option_select_aliases']);
			$values = split("\n", $fieldData['cmt_option_select_values']);
			foreach ($options as $n => $option) {
				$_options[] = [
					'optionValue' => $values[$n],
					'optionName' => $option
				];
			}
			$this->Parser->setParserVar ('options', $_options);
		}
		if (!empty ($this->validationErrors)) {
			$this->Parser->setParserVar ('validationErrors', $this->getValidationErrors ());
			$this->Parser->setParserVar ('validationRules', $this->getValidationRules ());
		}
		$content = $this->Parser->parseTemplate (PATHTOWEBROOT . 'templates/forms/' . $fieldData['cmt_fieldtype']. '.tpl');
		return $content;
	}



	public function getFormFields () {
		$fields = $this->FieldHandler->getAllFields ([
			'tableName' => $this->tableName,
			'getAll' => true
		]);

		$_fields = [];
		foreach ($fields as $field) {
			$_fields[$field['cmt_fieldname']] = $this->getFormField ($field['cmt_fieldname']);
		}

		return $_fields;
	}
}

?>
