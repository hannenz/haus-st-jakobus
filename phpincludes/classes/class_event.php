<?php
namespace Jakobus;

use Contentomat\TableMedia;
use Jakobus\Course;

class Event extends TableMedia {



	public function __construct() {
		parent::__construct();
		$this->Course = new Course();
	}



	public function findById($eventId) {

		$params = [
			// 'tableId' => 143,
			'where' => ' id='.$eventId.' '
		];

		$event = $this->getMedia($params);
		if (is_array($event)) {
			$event = array_shift($event);
		}
		if (empty($event)) {
			return false;
		}

		$event = array_merge($event, $this->Course->filter([
			'id' => $event['media_entry_id']
		])->findOne());
		$event['id'] = $eventId;

		$event = $this->Course->afterReadEvent($event);

		return $event;
	}

}
