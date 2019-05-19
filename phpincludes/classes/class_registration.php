<?php
namespace Jakobus;

use \Jakobus\Notification;
use \Jakobus\Event;


class Registration extends Model {

	protected $Notification;
	protected $Event;

	public function init () {

		$this->Notification = new Notification();
		$this->Notification->setTemplatesPath(PATHTOWEBROOT . "templates/registrations/notifications/");
		$this->Notification->setAdminNotificationRecipient("kursanmeldung@haus-st-jakobus.de");
		$this->Event = new Event();

		$this->setTableName('jakobus_registrations');
		$this->setupApplication();

		$this->setValidationRules([
			'registration_firstname' => '/^.+$/',
			'registration_lastname' => '/^.+$/',
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

	/**
	 * Get all registragions in agiven date range
	 *
	 * @return Array
	 */
	public function getInRange($begin, $end) {
		$query = <<<EOS
		SELECT Reg.*,Event.*,Course.*
		FROM jakobus_registrations AS Reg
		LEFT JOIN jakobus_events AS Event
		ON Event.id = Reg.registration_event_id
		LEFT JOIN jakobus_courses AS Course
		ON Course.id = Event.event_course_id
		WHERE Reg.registration_date BETWEEN '{$begin}' AND '{$end}'
EOS;

		if ($this->db->query($query) != 0) {
			throw new \Exception('Query failed: ' . $query);
		}

		$registrations = $this->db->getAll();

		return $registrations;
	}



	public function notifyUser($data) {
		$recipient = $data['registration_email'];

		return $this->Notification->notify(
			$recipient,
			'[Haus St. Jakobus] Anmeldebestätigung',
			'notify_user',
			$data
		);
	}



	public function notifyAdmin($data) {

		return $this->Notification->notifyAdmin(
			sprintf('[Haus St. Jakobus] Anmeldung zu %s', $data['event_title']),
			'notify_admin',
			$data
		);
	}
}
?>

