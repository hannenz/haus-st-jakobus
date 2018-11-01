<?php
namespace Jakobus;

use Contentomat\TableMedia;
use Contentomat\DBCex;
use Contentomat\Debug;
use Contentomat\Parser;

class Course extends Model {

	private $detailPageId = 10;
	private $registrationsPageId = 35;

	protected $TableMedia;


	protected $belongsTo = [
		'CourseCategory' => [
			'name' => 'CourseCategory', 
			'className' => 'Jakobus\CourseCategory',
			'foreignKey' => 'course_category_id',
			'foreignKeyField' => 'id'
		]
	];

	protected $hasMany = [
		'Event' => [
			'name' => 'Event',
			'className' => 'Jakobus\Event',
			'foreignKey' => 'event_course_id',
			'foreignKeyField' => 'id'
		]
	];

	
	public function init () {
		setlocale (LC_ALL, 'de_DE.utf-8');
		$this->setTableName ('jakobus_courses');
		$this->TableMedia = new TableMedia ();
		$this->Parser = new Parser();
	}



	public function findEventsByMonth ($year, $month) {
		$query = sprintf ("SELECT Media.media_date_begin,Media.media_date_end,Media.media_title,Course.* FROM cmt_tables_media AS Media LEFT JOIN jakobus_courses AS Course ON media_entry_id=Course.id WHERE YEAR(media_date_begin)=%u AND MONTH(media_date_begin)=%u", $year, $month);
		if ($this->db->query ($query) !== 0) {
			die ("Query failed: " . $query);
		}
		$events = $this->db->getAll ();
		foreach ($events as $n => $event) {
			$events[$n] = $this->afterRead($events);
		}
		return $events;
	}


	protected function afterRead ($result) {

		$result['course_detail_url'] = sprintf ("/%s/%u/%s,%u.html",
			$this->language,
			$this->detailPageId,
			$this->cmt->makeNameWebsave ($result['course_title']),
			$result['id']
		);

		
		// foreach ($events as $j => $event) {
		// 	$events[$j]['event_date_begin_fmt'] = strftime ('%a, %d.%B %Y', strtotime ($event['media_date_begin']));
		// 	$events[$j]['event_date_end_fmt'] = strftime ('%a, %d.%B %Y', strtotime ($event['media_date_end']));
		// }


		// Read images
		$images = $this->TableMedia->getMedia ([
			'tableName' => $this->tableName,
			'entryID' => $result['id'],
			'mediaType' => 'image'
		]);

		$result['images'] = $images;


		// Read costs
		$costsData = (array)json_decode($result['course_costs'], true);
		$costsItemsContent = '';
		foreach ($costsData as $costsItem) {
			$costsItem['value_fmt'] = sprintf('%.2f', (float)$costsItem['value']);
			$this->Parser->setMultipleParserVars($costsItem);
			$costsItemsContent .= $this->Parser->parseTemplate(PATHTOWEBROOT . 'templates/courses/costs_item.tpl');
		}
		$this->Parser->setParserVar('costsItemsContent', $costsItemsContent);
		$result['course_costs_fmt'] = $this->Parser->parseTemplate(PATHTOWEBROOT . 'templates/courses/costs_frame.tpl');

		return $result;
	}
}
?>
