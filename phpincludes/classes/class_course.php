<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\TableMedia;

class Course extends Model {

	private $detailPageId = 7;

	protected $cmt; 

	protected $TableMedia;

	protected $language;

	
	public function init () {
		setlocale (LC_ALL, 'de_DE.utf-8');
		$this->tableName = 'jakobus_courses';
		// TODO: How to order them by table media events?
		// $this->order (['movie_position' => 'asc']);
		$this->cmt = Contentomat::getContentomat ();
		$this->TableMedia = new TableMedia ();
	}

	public function setLanguage ($language = 'de') {
		$this->language = $language;
	}

	protected function afterRead ($results) {

		foreach ((array)$results as $n => $result) {
			$results[$n]['courseDetailUrl'] = sprintf ("/%s/%u/%s,%u.html",
				$this->language,
				$this->detailPageId,
				$this->cmt->makeNameWebsave ($result['course_title']),
				$result['id']
			);

			$events = $this->TableMedia->getMedia ([
				'tableName' => $this->tableName,
				'entryID' => $result['id'],
				'mediaType' => 'date'
				// TODO: Check/make sure that they are in chronological order!
			]);
			foreach ($events as $j => $event) {
				$events[$j]['event_date_begin_fmt'] = strftime ('%a, %d.%B %Y', strtotime ($event['media_date_begin']));
				$events[$j]['event_date_end_fmt'] = strftime ('%a, %d.%B %Y', strtotime ($event['media_date_end']));
			}
			$results[$n]['course_events'] = $events;

			$images = $this->TableMedia->getMedia ([
				'tableName' => $this->tableName,
				'entryID' => $result['id'],
				'mediaType' => 'image'
			]);

			$results[$n]['images'] = $images;
		}

		return $results;
	}
}
?>
