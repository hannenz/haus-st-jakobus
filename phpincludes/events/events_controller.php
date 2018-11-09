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



	public function init() {

		// $this->Course = new Course();
		$this->Event = new Event();

		$this->Event->setLanguage($this->pageLang);


		$this->templatesPath = $this->templatesPath . 'events/';
	}

	public function initActions($action = '') {
		parent::initActions();

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
	}



	/**
	 * Overview of upcoming events in a given month
	 * Year and month are read from GET parameters
	 */
	public function actionDefault() {
		$currentMonth = (int)date('m');
		$currentYear = (int)date('Y');

		$currentMonth = 1;

		for ($month = $currentMonth; $month <= 12; $month++) {
			$events = $this->Event->findByPeriod($currentYear, $month);

			if (!empty($events)) {
				$this->parser->setMultipleParserVars([
					'month' => $month,
					'month_fmt' => strftime('%B', strtotime(sprintf("%04u-%02u-01", $currentYear, $month))),
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
		$events = $this->Event->findByPeriod($year, $month, $day);

		$date_fmt = strftime('%d.%m.%Y', strtotime(sprintf('%04u-%02u-%02u', $year, $month, $day)));
		$this->parser->setParserVar('date_fmt', $date_fmt);

		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_day.tpl');
	}



	public function actionByMonth() { 
		$events = $this->Event->findByPeriod(
			(int)$this->getvars['year'],
			(int)$this->getvars['month']
		);

		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_month.tpl');
	}



	public function actionByYear() { 
		$events = $this->Event->findByPeriod((int)$this->getvars['year']);

		$this->parser->setParserVar('events', $events);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_year.tpl');
	}
}

$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new EventsController();
$content = $ctl->work();
?>

