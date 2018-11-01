<?php
namespace Jakobus;

use Jakobus\Course;


class Event extends Model {


	public function init() {
		setlocale (LC_ALL, 'de_DE.utf-8');
		$this->setTableName ('jakobus_events');
	}


	/**
	 * @param array
	 * @return array 
	 */
	public function validate($data) {

		$validationErrors = [];
		if (strtotime($data['event_begin']) >= strtotime($data['event_end'])) {
			$validationErrors[] = [
				'event_end' => 'End-Datum liegt vor dem Startdatum'
			];
		}

		if (!is_numeric($data['event_seats_max']) || (int)$data['event_seats_max'] < 0) {
			$validationErrors[] = [
				'event_seats_max' => 'Geben Sie eine positive Zahl ein'
			];
		}

		if (!is_numeric($data['event_seats_available']) || (int)$data['event_seats_available'] < 0) {
			$validationErrors[] = [
				'event_seats_available' => 'Geben Sie eine positive Zahl ein'
			];
		}

		if ((int)$data['event_seats_max'] < (int)$data['event_seats_available']) {
			$validationErrors[] = [
				'event_seats_available' => 'Mehr freie Plätze als verfügbar'
			];
		}

		return $validationErrors;
	}




	public function afterRead($event) {

		$event['event_begin_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['event_begin']));
		$event['event_end_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['event_end']));
		if ($event['event_begin'] == $event['end']) {
			$event['event_date_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['event_begin']));
		}
		else {
			$event['event_date_fmt'] = sprintf ("%s&thinsp;&ndash;&thinsp;%s", 
				$event['event_begin_fmt'] = strftime ('%d.%m', strtotime ($event['event_begin'])),
				$event['event_end_fmt'] = strftime ('%d.%m', strtotime ($event['event_end']))
			);
		}

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
}
?>
