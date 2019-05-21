<?php
namespace Jakobus;

use Jakobus\Model;
use \Exception;

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
	
	
}
?>
