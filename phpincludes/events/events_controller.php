<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Jakobus\Course;
use Jakobus\Event;

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

		if ($this->pageId == 43) {
			$this->action = 'soirees';
		}
	}



	/**
	 * Overview of upcoming events in the current year from current month 
	 */
	public function actionDefault() {
		$currentMonth = (int)date('m');
		$currentYear = (int)date('Y');

		// $currentMonth = 1;

		for ($month = $currentMonth; $month <= 12; $month++) {
			$events = $this->Event->findByPeriod($currentYear, $month);

			if (!empty($events)) {
				$this->parser->setMultipleParserVars([
					'month' => $month,
					'month_fmt' => strftime('%B', strtotime(sprintf("%04u-%02u-01", $currentYear, $month))),
					'year' => $currentYear
				]);	

				$this->parser->setParserVar('events', $events);
				$this->content .= $this->parser->parseTemplate($this->templatesPath . 'by_month.tpl');
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



	public function actionDetail() {
		if (!empty($this->eventId)) {
			$event = $this->Event->findById($this->eventId);

			$this->parser->setMultipleParserVars($event);
			$this->content = $this->parser->parseTemplate($this->templatesPath . 'detail.tpl');
		}
	}
}


$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new EventsController();
$content = $ctl->work();
?>

