<?php
namespace Jakobus;

use Contentomat\DBCex;
use Contentomat\Mail;

class Pilgrimpass extends Model {

	protected $adminNotificationRecipient = 'johannes.braun@hannenz.de';

	public function init () {
		parent::init ();

		$this->Mail = new Mail();

		$this->setTableName ('jakobus_pilgrimpasses');
		$this->setValidationRules([
			'pilgrimpass_firstname' => [
				'not-empty' => '/^.+$/',
			],
			'pilgrimpass_lastname' => [
				'not-empty' => '/^.+$/',
				// 'must-end-in-foo' => '/foo$/'
			],
			'pilgrimpass_birthday' => '/^\d{4}-\d{2}-\d{2}$/',
			'pilgrimpass_street_address' => '/^.+$/',
			'pilgrimpass_country' => '/^.+$/',
			'pilgrimpass_zip' => '/^\d{5}$/',
			// 'pilgrimpass_city' => '/^.+$/',
			'pilgrimpass_city' => [
				'not-emppty' => '/^.+$/',
				// 'custom' => 'validateIsUlm'
			],
			// 'pilgrimpass_phone' => '/^.+$/',
			'pilgrimpass_email' => '/^.+@.+\..{2,3}$/',
			'pilgrimpass_idnr' => '/^.+$/',
			'pilgrimpass_route' => '/^.+$/',
			'pilgrimpass_start_date' => '/^\d{4}-\d{2}-\d{2}$/',
			'pilgrimpass_start_location' => '/^.+$/',
			// 'pilgrimpass_message' => '/^.+$/',
			'pilgrimpass_motivation' => '/^.+$/',
			'pilgrimpass_transportation' => '/^.+$/',
			'pilgrimpass_payment_method' => '/^.+$/',
			// 'pilgrimpass_express' => '/^0|1$/',
			'pilgrimpass_amount' => '/^[0-9\,\.]+$/',
			'pilgrimpass_blz' => '/^\d+$/',
			'pilgrimpass_delivery_address_firstname' => '/^.+$/',
			'pilgrimpass_delivery_address_lastname' => '/^.+$/',
			'pilgrimpass_delivery_address_street' => '/^.+$/',
			'pilgrimpass_zip' => '/^\d{5}$/',
			'pilgrimpass_delivery_address_city' => '/^.+$/',
			'pilgrimpass_delivery_address_country' => '/^.+$/',
			'pilgrimpass_delivery_address_email' => '/^.+@.+\..{2,3}$/',
		]);
	}



	// protected function validateIsUlm ($value) {
	// 	$ret = ($value === "Ulm");
	// 	return $ret;
	// }


	public function notifyUser($data) {

		$this->Parser->setMultipleParserVars($data);
		$this->Parser->setParserVar('passes_count', count($data['pilgrimpasses']));
		$html = $this->Parser->parseTemplate(PATHTOWEBROOT."templates/pilgrimpasses/notifications/notify_user.html.tpl");
		$text = $this->Parser->parseTemplate(PATHTOWEBROOT."templates/pilgrimpasses/notifications/notify_user.txt.tpl");

		return $this->Mail->send([
			'senderMail' => 'noreply@haus-st-jakobus.de',
			'senderName' => 'Haus St. Jakobus',
			'recipient' => $data['pilgrimpass_delivery_address_email'],
			'subject' => "[Haus St. Jakobus] Eingangsbestätigung ",
			'text' => $text,
			'html' => $html
		]);
	}

	public function notifyAdmin($data) {
		$this->Parser->setMultipleParserVars($data);
		$this->Parser->setParserVar('passes_count', count($data['pilgrimpasses']));
		$html = $this->Parser->parseTemplate(PATHTOWEBROOT."templates/pilgrimpasses/notifications/notify_admin.html.tpl");
		$text = $this->Parser->parseTemplate(PATHTOWEBROOT."templates/pilgrimpasses/notifications/notify_admin.txt.tpl");

		return $this->Mail->send([
			'senderMail' => 'noreply@haus-st-jakobus.de',
			'senderName' => 'Haus St. Jakobus',
			'recipient' => $this->adminNotificationRecipient,
			'subject' => "[Haus St. Jakobus] Antrag Pilgerausweis",
			'text' => $text,
			'html' => $html
		]);
	}

}
?>

