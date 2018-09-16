<?php
namespace Jakobus;

use \Contentomat\Mail;
use \Contentomat\Parser;
use \Jakobus\Event;


class Registration extends Model {


	public function init () {
		parent::init ();

		$this->Mail = new Mail();
		$this->Event = new Event();

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



	public function notifyUser($data) {
		$parser = new Parser();
		$event = $this->Event->findById($data['registration_event_id']);

		$parser->setMultipleParserVars($data);
		$html = $parser->parseTemplate(PATHTOWEBROOT."templates/registrations/notifications/notify_user.html.tpl");
		$text = $parser->parseTemplate(PATHTOWEBROOT."templates/registrations/notifications/notify_user.txt.tpl");

		return $this->Mail->send([
			'senderMail' => 'noreply@haus-st-jakobus.de',
			'senderName' => 'Haus St. Jakobus',
			'recipient' => $data['registration_email'],
			'subject' => "[Haus St. Jakobus] Anmeldebestätigung",
			'text' => $text,
			'html' => $html
		]);
	}
}
?>

