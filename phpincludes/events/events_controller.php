<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Jakobus\Course;
use Jakobus\CourseCategory;
use Jakobus\Event;

use Contentomat\DBCex;

use \Exception;


class EventsController extends Controller {


	/**
	 * @var Jakobus\Course
	 */
	// protected $Course;

	/**
	 * @var Jakobus\Event
	 */
	protected $Event;


	/**
	 * @var int
	 */
	protected $eventId;



	public function init() {

		// $this->Course = new Course();
		$this->Event = new Event();
		$this->CourseCategory = new CourseCategory();

		$this->Event->setLanguage($this->pageLang);


		$this->templatesPath = $this->templatesPath . 'events/';
	}



	public function initActions($action = '') {
		parent::initActions();

		if (preg_match('/,(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
			$this->eventId = (int)$matches[1];
			$this->action = 'detail';
			return;
		}
		// Link from calendar points to a specific day
		if (!empty($this->getvars['year']) && !empty($this->getvars['month']) && !empty($this->getvars['day'])) {
			$this->action = 'byDay';
			return;
		}

		if (!empty($this->getvars['year']) && !empty($this->getvars['month'])) {
			$this->action = 'byMonth';
			return;
		}

		if (!empty($this->getvars['year'])) {
			$this->action = 'byYear';
			return;
		}

		// Homepage: Upcoming events
		if ($this->pageId == 2) {
			$this->action = 'upcoming';
		}

		if ($this->pageId == 43) {
			$this->action = 'soirees';
		}

	}



	/**
	 * Overview of upcoming events in the current year from current month 
	 */
	public function actionDefault() {

		if (PAGEID == 107) {
			return $this->actionListByCategory();
		}

		// Get the most future event
		$lastEvent = $this->Event->getLastEvent();
		$lastYearMonthStr = strftime('%Y-%m', strtotime($lastEvent['event_begin']));

		// Current year / month
		$currentMonth = (int)date('m');
		$currentYear = (int)date('Y');

		// Loop until latest event's Year-Month
		$month = $currentMonth;
		$year = $currentYear;
		while (sprintf('%4u-%02u', $year, $month) != $lastYearMonthStr) {

			$events = $this->Event->findByPeriod($year, $month, null, true);

			if (!empty($events)) {
				$this->parser->setMultipleParserVars([
					'month' => $month,
					'month_fmt' => strftime('%B', strtotime(sprintf("%04u-%02u-01", $year, $month))),
					'year' => $year
				]);	

				$this->parser->setParserVar('events', $events);
				$this->content .= $this->parser->parseTemplate($this->templatesPath . 'by_month.tpl');
			}

			$month++;
			if ($month > 12) {
				$month = 1;
				$year++;
			}
		}
	}

	public function actionByDay() {
		$year = (int)$this->getvars['year'];
		$month = (int)$this->getvars['month'];
		$day = (int)$this->getvars['day'];
		// $events = $this->Event->findByPeriod($year, $month, $day);
		$events = $this->Event->findByDay($year, $month, $day);

		$date_fmt = strftime('%d.%m.%Y', strtotime(sprintf('%04u-%02u-%02u', $year, $month, $day)));
		$this->parser->setParserVar('date_fmt', $date_fmt);

		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_day.tpl');
	}



	public function actionByMonth() { 
		if (!empty($this->getvars['year']) && !empty($this->getvars['month'])) {
			$year = (int)$this->getvars['year'];
			$month = (int)$this->getvars['month'];
		}
		else {
			$year = (int)date('Y');
			$month = (int)date('m');
		}

		$events = $this->Event->findByPeriod($year, $month);

		$this->parser->setParserVar('month_fmt', strftime('%B', strtotime(sprintf("%04u-%02u-01", $year, $month))));
		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_month.tpl');
	}



	public function actionByYear() { 
		$events = $this->Event->findByPeriod((int)$this->getvars['year']);

		$this->parser->setParserVar('year', $this->getvars['year']);
		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_year.tpl');
	}



	public function actionSoirees() {
		$events = $this->Event->filter([
			'event_is_soiree' => 1
		])->findAll();

		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'soirees.tpl');
	}


	public function actionListByCategory() {
		$categoryId = (int)$_REQUEST['categoryId'];
		if (empty($categoryId)) {
			$data = [];
			$categories = $this->CourseCategory->findAll();
			// foreach ($categories as $category) {
			// 	$events = $this->Event->filter(['event_course_category_id' => $category['id']]);
			// 	if (!empty($events)) {
			// 		$data[] = array_merge($category, [
			// 			'events' => $events
			// 		]);
			// 	}
			// }
			$this->parser->setParserVar('categories', $categories);
			$this->content = $this->parser->parseTemplate($this->templatesPath . 'all_categories.tpl');
			return;

		}
		else {
			$events = $this->Event->filter([
				'event_course_category_id' => $categoryId
			])->findAll();
			$this->parser->setParserVar('events', $events);
			$this->parser->setMultipleParserVars($this->CourseCategory->findById($categoryId));
		}
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_category.tpl');
	}


	public function actionDetail() {
		if (!empty($this->eventId)) {
			$event = $this->Event->findById($this->eventId);

			$this->parser->setMultipleParserVars($event);
			$this->content = $this->parser->parseTemplate($this->templatesPath . 'detail.tpl');
		}
	}


	public function actionUpcoming() {
		$events = $this->Event->getUpcoming(3);
		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'upcoming.tpl');
	}
}


$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new EventsController();
$content = $ctl->work();
?>

