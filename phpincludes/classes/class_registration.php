<?php
namespace Jakobus;


class Registration extends Model {


	public function init () {
		parent::init ();

		$this->setTableName ('jakobus_registrations');

		$this->setValidationRules([
			'registration_firstname' => [
				'not-empty' => '/^.+$/',
			],
			'registration_lastname' => [
				'not-empty' => '/^.+$/',
			],
			'registration_birthday' => '/^\d{4}-\d{2}-\d{2}$/',
			'registration_street_address' => '/^.+$/',
			'registration_country' => '/^.+$/',
			'registration_zip' => '/^\d{5}$/',
			'registration_city' => [
				'not-empty' => '/^.+$/'
			],
			'registration_phone' => '/^.+$/',
			'registration_email' => '/^.+@.+\..{2,3}$/',
		]);
	}
}
?>

