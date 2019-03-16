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
	 * @var int
	 */
	private $detailPageId = 44;

	/**
	 * @var int
	 */
	private $courseDetailPageId = 42;


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



	/**
	 * Find events at a given day
	 * Will also find events that are in progress at a given day (which
	 * findByPeriod does not)
	 *
	 * @param int year
	 * @param int month
	 * @param int day
	 * @return array
	 * @access public
	 */
	public function findByDay($year, $month, $day) {
		$query = sprintf("SELECT * FROM jakobus_events WHERE '%4u-%02u-%02u' BETWEEN event_begin AND event_end", $year, $month, $day);
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
		->order(['event_begin' => 'ASC'])
		->findAll();

		return $events;
	}


	/**
	 * Get upcoming events
	 *
	 * @param int 	Nr of events to return, <= 0: all (default)
	 * @return array
	 */
	public function getUpcoming($limit = 0) {
		$this->filter([
			'event_begin >' => 'NOW()'
		])
		->order(['event_begin' => 'ASC']);

		if ($limit > 0) {
			$this->limit($limit);
		}

		$events = $this->findAll();

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

		$event['event_begin_fmt'] = strftime ('%a, %d.%m.%Y', strtotime ($event['event_begin']));
		$event['event_end_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['event_end']));
		$event['event_time_fmt'] = strftime('%H:%M', strtotime($event['event_begin']));

		// Test if begin and end date are at the same day
		$y1 = date('y', strtotime($event['event_begin']));
		$m1 = date('m', strtotime($event['event_begin']));
		$d1 = date('d', strtotime($event['event_begin']));
		$y2 = date('y', strtotime($event['event_end']));
		$m2 = date('m', strtotime($event['event_end']));
		$d2 = date('d', strtotime($event['event_end']));
		if ($y1 == $y2 && $m1 == $m2 && $d1 == $d2) {
		// if ($event['event_end'] == '0000-00-00 00:00:00') {
			$event['event_date_fmt'] = strftime ('%a, %d.%m.%Y', strtotime ($event['event_begin']));
		}
		else {
			$event['event_date_fmt'] = sprintf ("%s&thinsp;&ndash;&thinsp;%s", 
				strftime ('%a, %d.%m.', strtotime ($event['event_begin'])),
				strftime ('%a, %d.%m.', strtotime ($event['event_end']))
			);
		}

		$event['event_registration_before_fmt'] = strftime('%d.%m.%Y', strtotime($event['event_registration_before']));
		if (!empty($event['event_course_id'])) {
			$course = $this->Course->filter([
				'id' => $event['event_course_id']
			])
			->findOne();
			unset($course['id']);
			$event = array_merge($event, $course);
		}
		else {
			$event['event_course_id'] = 0;
		}

		// $Registration = new Registration();
		// $registrations = $Registration->filter([
		// 	'registration_event_id' => $event['id']
		// ])->findAll(['fetchAssociations' => false]);
        //
		// $event['eventSeatsLeft'] = $event['event_seats_max'] - count($registrations);

		$event['course_detail_url'] = sprintf ('/%s/%u/%s,%u.html',
			$this->language,
			$this->courseDetailPageId,
			$this->cmt->makeNameWebSave ($event['course_title']),
			$event['event_course_id']
		);

		$event['event_subscribe_url'] = sprintf('/%s/%u/%s,%u.html',
			$this->language,
			$this->registrationsPageId,
			$this->cmt->makeNameWebsave('Anmeldung zu ' . $event['course_title']),
			$event['id']
		);

		$event['event_detail_url'] = sprintf('/%s/%u/%s,%u.html',
			$this->language,
			$this->detailPageId,
			$this->cmt->makeNameWebsave($event['event_title']),
			$event['id']
		);

		$event['event_can_registrate'] = true;
		// If event does not require registration ...

		if (!$event['event_needs_registration']) {
			$event['event_can_registrate'] = false;
		}

		// If event (start date) has passed yet, no registation is possible any more
		if (strtotime($event['event_begin']) < time()) {
			$event['event_can_registrate'] = false;
		}
		// If registrate_before date has passed, no registration is possible any more
		if ($event['event_needs_registration']) {
			if ($event['event_registration_before'] != '0000-00-00' && strtotime($event['event_registration_before']) < time()) {
				$event['event_can_registrate'] = false;
			}
		}

		$event['event_seats_available'] = $event['event_seats_max'] - $event['event_seats_taken'];
		// If no more seats available, ... no luck ;-)
		if ($event['event_seats_available'] == 0) {
			$event['event_can_registrate'] = false;
		}

		if ($event['event_seats_max'] > 0) {
			$event['event_seats_perc'] = (int)($event['event_seats_taken'] / $event['event_seats_max'] * 100);
		}

		if ($event['event_seats_perc'] > 90) {
			$event['event_seats_availability_class'] = 'low';
		}
		else if ($event['event_seats_perc'] > 66) {
			$event['event_seats_availability_class'] = 'medium';
		}
		else {
			$event['event_seats_availability_class'] = 'high';
		}
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
