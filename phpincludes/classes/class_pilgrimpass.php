<?php
namespace Jakobus;

use Contentomat\DBCex;

class Pilgrimpass extends Model {

	public function init () {
		parent::init ();
		$this->setTableName ('jakobus_pilgrimpasses');
		$this->setValidationRules([
			'pilgrimpass_firstname' => '/^.+$/',
			'pilgrimpass_lastname' => '/^.+$/',
			'pilgrimpass_birthday' => '/^\d{4}-\d{2}-\d{2}$/',
			'pilgrimpass_street_address' => '/^.+$/',
			'pilgrimpass_country' => '/^.+$/',
			'pilgrimpass_zip' => '/^\d{5}$/',
			'pilgrimpass_city' => '/^.+$/',
			'pilgrimpass_phone' => '/^.+$/',
			'pilgrimpass_email' => '/^.+@.+\..{2,3}$/',
			'pilgrimpass_idnr' => '/^.+$/',
			'pilgrimpass_route' => '/^.+$/',
			'pilgrimpass_start_date' => '/^\d{4}-\d{2}-\d{2}$/',
			'pilgrimpass_start_location' => '/^.+$/',
			'pilgrimpass_message' => '/^.+$/',
			'pilgrimpass_motivation' => '/^.+$/',
			'pilgrimpass_transportation' => '/^.+$/',
			'pilgrimpass_payment_method' => '/^.+$/',
			'pilgrimpass_express' => '/^0|1$/',
			'pilgrimpass_amount' => '/^[0-9\,\.]+$/',
			'pilgrimpass_blz' => '/^\d+$/'
		]);
	}

}
?>

