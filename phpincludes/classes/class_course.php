<?php
namespace Jakobus;

use Contentomat\TableMedia;
use Contentomat\DBCex;
use Contentomat\Debug;
use Contentomat\Parser;
use Contentomat\CmtPage;
use Jakobus\Event;

class Course extends Model {

	/**
	 * @access private
	 * @var int
	 */
	private $detailPageId = 42;

	/**
	 * @access private
	 * @var int
	 */
	private $overviewPageId = 39;

	/**
	 * @access private
	 * @var int
	 */
	private $tableId;

	/**
	 * @var Contentomat\TableMedia
	 */
	protected $TableMedia;

	/**
	 * @var Contentomat\CmtPage
	 */
	protected $CmtPage;

	

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

		// Get table id (for table data layout)
		$this->db->query(sprintf("SELECT id FROM cmt_tables WHERE cmt_tablename='%s'", $this->tableName));
		$r = $this->db->get();
		$this->tableId = (int)$r['id'];

		$this->TableMedia = new TableMedia ();
		$this->Parser = new Parser();
		$this->CmtPage = new CmtPage();
	}



	protected function afterRead ($result) {

		$result['course_detail_url'] = sprintf ("/%s/%u/%s,%u.html",
			$this->language,
			$this->detailPageId,
			$this->cmt->makeNameWebsave ($result['course_title']),
			$result['id']
		);

		$result['course_overview_url'] = sprintf('%s%s',
			$this->CmtPage->makePageFilePath($this->overviewPageId, $this->language),
			$this->CmtPage->makePageFileName($this->overviewPageId, $this->language)
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

		// Read documents
		$documents = $this->TableMedia->getMedia([
			'tableName' => $this->tableName,
			'entryId' => $result['id'],
			'mediaType' => 'document'
		]);
		foreach ($documents as  &$document) {
			$info = pathinfo(PATHTOWEBROOT . 'media/courses/'.$document['media_document_file_internal']);
			$document['media_document_file_extension'] = $info['extension'];
		}
		$result['documents'] = $documents;


		// Read costs
		$costsData = (array)json_decode($result['course_costs'], true);
		if (!empty($costsData)) {
			$costsItemsContent = '';
			foreach ($costsData as $costsItem) {
				if (ctype_digit($costsItem['value'][0])) {
					$costsItem['value_fmt'] = sprintf('%.2f &euro;', (float)$costsItem['value']);
				}
				else {
					$costsItem['value_fmt'] = $costsItem['value'];
				}
				$this->Parser->setMultipleParserVars($costsItem);
				$costsItemsContent .= $this->Parser->parseTemplate(PATHTOWEBROOT . 'templates/courses/costs_item.tpl');
			}
			$this->Parser->setParserVar('costsItemsContent', $costsItemsContent);
			$result['course_costs_fmt'] = $this->Parser->parseTemplate(PATHTOWEBROOT . 'templates/courses/costs_frame.tpl');
		}

		return $result;
	}

	/**
	 * Getter for overviewPageId
	 *
	 * @return string
	 */
	public function getOverviewPageId() {
	    return $this->overviewPageId;
	}

	/**
	 * Getter for tableId
	 *
	 * @return int
	 */
	public function getTableId() {
	    return $this->tableId;
	}
}
?>
