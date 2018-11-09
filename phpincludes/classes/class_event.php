<?php
namespace Jakobus;

use Jakobus\Course;


class Event extends Model {

	/**
	 * @var int
	 */
	private $registrationsPageId = 35;


	/**
	 * @var int
	 */
	private $overviewPageId = 38;

	/**
	 * @var Jakobus\Course
	 */
	protected $Course;



	public function init() {
		setlocale (LC_ALL, 'de_DE.utf-8');
		$this->setTableName ('jakobus_events');
		$this->Course = new Course();
		// $this->Registration = new Registration();
	}


	/**
	 * @param array
	 * @return array 
	 */
	public function validate($data) {

		$validationErrors = [];
		
		if ($data['event_end'] != '0000-00-00 00:00:00' && (strtotime($data['event_begin']) >= strtotime($data['event_end']))) {
			$validationErrors[] = [
				'event_end' => 'End-Datum liegt vor dem Startdatum'
			];
		}

		if (!is_numeric($data['event_seats_max']) || (int)$data['event_seats_max'] < 0) {
			$validationErrors[] = [
				'event_seats_max' => 'Geben Sie eine positive Zahl ein'
			];
		}

		// if (!is_numeric($data['event_seats_available']) || (int)$data['event_seats_available'] < 0) {
		// 	$validationErrors[] = [
		// 		'event_seats_available' => 'Geben Sie eine positive Zahl ein'
		// 	];
		// }

		// if ((int)$data['event_seats_max'] < (int)$data['event_seats_available']) {
		// 	$validationErrors[] = [
		// 		'event_seats_available' => 'Mehr freie Plätze als verfügbar'
		// 	];
		// }

		return $validationErrors;
	}



	/**
	 * Find events in a certain time period
	 
	 * @param int year
	 * @param int month, optional
	 * @param int day, optional
	 * @return array
	 * @access public
	 */
	public function findByPeriod($year, $month = null, $day = null) {
		$query = sprintf ("SELECT Event.* FROM jakobus_events AS Event WHERE YEAR(event_begin)=%u", (int)$year);
		if ($month != null) {
			$query .= sprintf(" AND MONTH(event_begin)=%u", (int)$month);
		}
		if ($day != null) {
			$query .= sprintf(" AND DAY(event_begin)=%u", (int)$day);
		}
		if ($this->db->query($query) !== 0) {
			throw new Exception("Query failed: " . $query);
		}
		$events = $this->db->getAll();

		foreach ($events as &$event) {
			$event = $this->afterRead($event);
		}

		return $events;
	}


	public function getPast() {
		$events = $this->filter([
			'event_end <' => 'NOW()'
		])
		->findAll();

		return $events;
	}

	public function getUpcoming() {
		$events = $this->filter([
			'event_begin >' => 'NOW()'
		])
		->findAll();

		return $events;
	}

	// public function findByDay($year, $month, $day) {
	// 	$query = sprintf ("SELECT Event.* FROM jakobus_events AS Event WHERE YEAR(event_begin)=%u AND MONTH(event_begin)=%u AND DAY(event_begin)=%u", $year, $month, $day);
	// 	if ($this->db->query ($query) !== 0) {
	// 		die ("Query failed: " . $query);
	// 	}
	// 	$events = $this->db->getAll ();
    //
	// 	foreach ($events as &$event) {
	// 		$event = $this->afterRead($event);
	// 	}
    //
	// 	return $events;
	// }
    //
    //
    //
	// public function findByMonth ($year, $month) {
	// 	$query = sprintf ("SELECT Event.* FROM jakobus_events AS Event WHERE YEAR(event_begin)=%u AND MONTH(event_begin)=%u", $year, $month);
	// 	if ($this->db->query ($query) !== 0) {
	// 		die ("Query failed: " . $query);
	// 	}
	// 	$events = $this->db->getAll ();
    //
	// 	foreach ($events as &$event) {
	// 		$event = $this->afterRead($event);
	// 	}
    //
	// 	return $events;
	// }
    //
    //
    //
	// public function findByYear($year) {
	// 	$query = sprintf ("SELECT Event.* FROM jakobus_events AS Event WHERE YEAR(event_begin)=%u", $year);
	// 	if ($this->db->query ($query) !== 0) {
	// 		die ("Query failed: " . $query);
	// 	}
	// 	$events = $this->db->getAll ();
    //
	// 	foreach ($events as &$event) {
	// 		$event = $this->afterRead($event);
	// 	}
    //
	// 	return $events;
	// }
    //


	public function afterRead($event) {

		$event['event_begin_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['event_begin']));
		$event['event_end_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['event_end']));

		if ($event['event_end'] == '0000-00-00 00:00:00') {
			$event['event_date_fmt'] = strftime ('%a, %d.%m.%Y', strtotime ($event['event_begin']));
		}
		else {
			$event['event_date_fmt'] = sprintf ("%s&thinsp;&ndash;&thinsp;%s", 
				$event['event_begin_fmt'] = strftime ('%d.%m.', strtotime ($event['event_begin'])),
				$event['event_end_fmt'] = strftime ('%d.%m.', strtotime ($event['event_end']))
			);
		}

		$event['event_registration_before_fmt'] = strftime('%d.%m.%Y', strtotime($event['event_registration_before']));

		$course = $this->Course->filter([
			'id' => $event['event_course_id']
		])
		->findOne();
		unset($course['id']);
		$event = array_merge($event, $course);

		$Registration = new Registration();
		$registrations = $Registration->filter([
			'registration_event_id' => $event['id']
		])->findAll(['fetchAssociations' => false]);

		$event['EventSeatsLeft'] = $event['event_seats_max'] - count($registrations);

		$event['course_detail_url'] = sprintf ('/%s/%u/%s,%u.html',
			$this->language,
			$this->detailPageId,
			$this->cmt->makeNameWebSave ($event['course_title']),
			$event['id']
		);

		$event['event_subscribe_url'] = sprintf('/%s/%u/%s,%u.html',
			$this->language,
			$this->registrationsPageId,
			$this->cmt->makeNameWebsave('Anmeldung zu ' . $event['course_title']),
			$event['id']
		);

		return $event;
	}

	/**
	 * Getter for registrationPageId
	 *
	 * @return int
	 */
	public function getRegistrationPageId() {
	    return $this->registrationPageId;
	}


	/**
	 * Getter for overviewPageId 
	 *
	 * @return int
	 */
	public function getOverviewPageId () {
	    return $this->overviewPageId ;
	}
}
?>
