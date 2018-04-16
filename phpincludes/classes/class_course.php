<?php
namespace Jakobus;

use Contentomat\TableMedia;
use Contentomat\DBCex;
use Contentomat\Debug;

class Course extends Model {

	private $detailPageId = 10;

	protected $TableMedia;


	protected $belongsTo = [
		[
			'className' => 'CourseCategory',
			'foreignKey' => 'course_category_id',
			'foreignKeyField' => 'id'
		]
	];

	
	public function init () {
		setlocale (LC_ALL, 'de_DE.utf-8');
		$this->setTableName ('jakobus_courses');
		$this->TableMedia = new TableMedia ();
	}



	public function findEventsByMonth ($year, $month) {
		$query = sprintf ("SELECT Media.media_date_begin,Media.media_date_end,Media.media_title,Course.* FROM cmt_tables_media AS Media LEFT JOIN jakobus_courses AS Course ON media_entry_id=Course.id WHERE YEAR(media_date_begin)=%u AND MONTH(media_date_begin)=%u", $year, $month);
		if ($this->db->query ($query) !== 0) {
			die ("Query failed: " . $query);
		}
		$events = $this->db->getAll ();
		$events = $this->afterReadEvents ($events);
		return $events;
	}


	protected function afterRead ($results) {

		foreach ((array)$results as $n => $result) {
			$results[$n]['course_detail_url'] = sprintf ("/%s/%u/%s,%u.html",
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
			
			// foreach ($events as $j => $event) {
			// 	$events[$j]['event_date_begin_fmt'] = strftime ('%a, %d.%B %Y', strtotime ($event['media_date_begin']));
			// 	$events[$j]['event_date_end_fmt'] = strftime ('%a, %d.%B %Y', strtotime ($event['media_date_end']));
			// }
			$results[$n]['course_events'] = $this->afterReadEvents ($events);

			$images = $this->TableMedia->getMedia ([
				'tableName' => $this->tableName,
				'entryID' => $result['id'],
				'mediaType' => 'image'
			]);

			$results[$n]['images'] = $images;
		}

		return $results;
	}

	protected function afterReadEvents ($events) {
		foreach ($events as $n => $event) {
			$events[$n]['event_begin_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['media_date_begin']));
			$events[$n]['event_end_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['media_date_end']));
			if ($event['media_date_begin'] == $event['media_date_end']) {
				$events[$n]['event_date_fmt'] = strftime ('%d.%m.%Y', strtotime ($event['media_date_begin']));
			}
			else {
				$events[$n]['event_date_fmt'] = sprintf ("%s&thinsp;&ndash;&thinsp;%s", 
					$events[$n]['event_begin_fmt'] = strftime ('%d.%m', strtotime ($event['media_date_begin'])),
					$events[$n]['event_end_fmt'] = strftime ('%d.%m', strtotime ($event['media_date_end']))
				);
			}
			$events[$n]['course_detail_url'] = sprintf ('/%s/%u/%s,%u.html',
				$this->language,
				$this->detailPageId,
				$this->cmt->makeNameWebSave ($event['course_title']),
				$event['id']
			);
		}
		return $events;
	}
}
?>
