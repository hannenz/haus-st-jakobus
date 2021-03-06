<?php
namespace Jakobus;

use Jakobus\Model;
use \Exception;

define('PAYMENT_STATUS_OPEN', 0);
define('PAYMENT_STATUS_PAYED', 100);


/**
 * Order
 *
 * @class Order
 * @package jakobus
 * @author Johannes Braun <johannes.braun@agentur-halma.de>
 */
class Order extends Model {


	public function init() {
		setlocale (LC_ALL, 'de_DE.utf-8');
		$this->setTableName ('jakobus_orders');
		$this->setValidationRules([
			'order_delivery_address_firstname' => '/^.+$/',
			'order_delivery_address_lastname' => '/^.+$/',
			'order_delivery_address_street' => '/^.+$/',
			'order_delivery_address_zip' => '/^\d{5}$/',
			'order_delivery_address_city' => '/^.+$/',
			'order_delivery_address_country' => '/^.+$/',
			'order_delivery_address_email' => '/^.+@.+\..{2,3}$/',
		]);
	}

	/**
	 * undocumented function
	 *
	 * @return int 			The new order's id
	 * @throws Exception
	 */
	public function save($data = null, $options = []) {
		if (!parent::save($data, $options)) {
			throw new Exception("Failed to save order!");
		}
		return $this->db->getLastInsertedId();
	}
	

	/**
	 * Set payment_status of order
	 *
	 * @param int 		The order's id	
	 * @param int 		PAYMENT_STATUS
	 * @throws Exception
	 * @return void
	 */
	public function setPaymentStatus($id, $status) {

		$data = [
			'order_payment_status' => $status
		];

		if ($status == PAYMENT_STATUS_PAYED) {
			$data['order_payment_date'] = strftime('%F %T');
		}

		$setQuery = $this->db->makeSetQuery($data);
		$query = sprintf("UPDATE %s SET %s WHERE id=%u", $this->tableName, $setQuery, $id);
		if ($this->db->query($query) !== 0) {
			throw new Exception("Query failed: " . $query);
		}
	}
	
}
?>
