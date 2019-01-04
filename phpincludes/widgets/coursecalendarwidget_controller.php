<?php
namespace Jakobus;
use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Contentomat\CmtPage;
use Jakobus\Event;
use Jakobus\CourseCategory;
use Jakobus\Calendar;

use \Exception;


// error_reporting(E_ALL);
// ini_set('display_errors', true);

class CourseCalendarWidgetController extends Controller {



	protected $Event;

	protected $year;

	protected $month;

	protected $widgetPageId = 41;



	public function init() {

		$this->Calendar = new Calendar();
		$this->CmtPage = new CmtPage();

		$this->Event = new Event();
		// $this->CourseCategory = new CourseCategory ();
		// $this->CourseCategory->setLanguage ($this->pageLang);
		// $this->CourseCategory->order (['course_category_position' => 'asc']);
		// $this->templatesPath = $this->templatesPath . 'course_categories/';


		if (!empty($this->getvars['year']) && !empty($this->getvars['month'])) {
			$this->year = $this->getvars['year'];
			$this->month = $this->getvars['month'];
		}
		else {
			$this->year = date('Y');
			$this->month = date('m');
		}

		if ($this->pageId == $this->widgetPageId) {
			$this->action = 'getCalendarWidget';
		}
	}

	public function actionDefault() {
		$year = date('Y', strtotime(sprintf('%4u-%02u', $this->year, $this->month)));
		$month = date('m', strtotime(sprintf('%4u-%02u', $this->year, $this->month)));
		$events = $this->Event->findByPeriod($year, $month);
		$daysWithLink = [];

		foreach ($events as $event) {

			$beginTs = strtotime($event['event_begin']);
			$endTs = strtotime($event['event_end']);
			for ($ts = $beginTs; $ts < $endTs; $ts += 86400) {
				$dayOfMonth = (int)strftime('%d', $ts);
				$daysWithLink[$dayOfMonth] = sprintf('/de/10/Programm.html?action=byDay&day=%04u-%02u-%02u', SELFURL, $year, $month, $dayOfMonth);
			}

			// $dayOfMonth = strftime('%d', strtotime ($event['event_begin']));
			// $daysWithLink[$dayOfMonth] = sprintf('/de/10/Programm.html?action=byDay&day=%04u-%02u-%02u', SELFURL, $year, $month, $dayOfMonth);
		}
		// var_dump($daysWithLink); die();
		
		$this->Calendar->setDaysWithLink($daysWithLink);
		$calendarContent = $this->Calendar->createCalendar([
			'link' => sprintf('%s%s?year={YEAR}&month={MONTH}&day={DAY}',
				$this->CmtPage->makePageFilePath($this->Event->getOverviewPageId()),
				$this->CmtPage->makePageFileName($this->Event->getOverviewPageId())
			),
			'year' => $year,
			'month' => $month,
			'linkPastDays' => true
		]);
		$this->parser->setMultipleParserVars([
			'calendarContent' => $calendarContent,
			'month' => strftime('%B %Y', strtotime(sprintf('%4u-%02u', $year, $month))),
			'year' => $year,
			'nextMonth' => strftime('%m', strtotime(sprintf('%4u-%02u + 1 month', $year, $month))),
			'nextYear' => strftime('%Y', strtotime(sprintf('%4u-%02u + 1 month', $year, $month))),
			'prevMonth' =>strftime('%m', strtotime(sprintf('%4u-%02u - 1 month', $year, $month))),
			'prevYear' => strftime('%Y', strtotime(sprintf('%4u-%02u - 1 month', $year, $month))),
			'baseUrl' => sprintf('%s%s', $this->CmtPage->makePageFilePath($this->widgetPageId), $this->CmtPage->makePageFileName($this->widgetPageId))
		]);
		$this->content = $this->parser->parseTemplate(PATHTOWEBROOT . "templates/widgets/calendar_widget.tpl");
		// $this->content = '<nav class="widget">' . $calendarContent . '</nav>';
	}

	public function actionGetCalendarWidget() {
		$this->isAjax = true;
		$this->changeAction('default');
	}
}

$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new CourseCalendarWidgetController();
$content = $ctl->work();
?>
