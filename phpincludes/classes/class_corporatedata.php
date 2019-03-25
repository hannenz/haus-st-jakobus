<?php
namespace Jakobus;

use Contentomat\DBCex;
use \Exception;


class CorporateData {

	protected $db;

	protected $data;

	protected $tableName = 'jakobus_corporate_data';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->db = new DBCex();
		$query = sprintf("SELECT * FROM %s WHERE corporate_data_is_active=1 ORDER BY id ASC LIMIT 1", $this->tableName);
		if ($this->db->query($query) != 0) {
			throw new Exception("Query failed");
		}

		$this->data = $this->db->get();
	}



	/**
	 * Get a specific field of the dataset
	 *
	 * @access public
	 * @throws Exception
	 * @param string 		The field name (without the `corporate_data`-suffix)
	 * @return string
	 */
	public function getField($fieldName) {
		$_fieldName = 'corporate_data_'.$fieldName;
		if (!isset($this->data[$_fieldName])) {
			throw new Exception("No such field: {$_fieldName}");
		}
		return $this->data[$_fieldName];
	}



	/**
	 * Get all data 
	 *
	 * @access public
	 * @throws Exception
	 * @return Array
	 */
	public function getData() {
		return $this->data;
	}
	
}
?>
