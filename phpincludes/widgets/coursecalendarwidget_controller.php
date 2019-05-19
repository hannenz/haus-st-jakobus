<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\CmtPage;
use Jakobus\Event;
use Jakobus\Calendar;

use \Exception;


/**
 * Render a calendar widget for the sidebar
 * The calendar lists all events in the given
 * month
 *
 * @class CourseCalendarWidgetController
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 */
class CourseCalendarWidgetController extends Controller {

	/**
	 * @var Jakobus\Calendar
	 */
	protected $Calendar;

	/**
	 * @var Jakobus\Event
	 */
	protected $Event;

	/**
	 * @var Contentomat\CmtPage
	 */
	protected $CmtPage;

	/**
	 * @var int
	 */
	protected $year;

	/**
	 * @var int
	 */
	protected $month;

	/**
	 * @var int
	 */
	protected $widgetPageId = 41;



	public function init() {

		$this->Calendar = new Calendar();
		$this->CmtPage = new CmtPage();

		$this->Event = new Event();

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


	/**
	 * Default action: Render the calendar widget
	 * for the given month
	 *
	 * @access public
	 * @return void
	 */
	public function actionDefault() {
		$year = date('Y', strtotime(sprintf('%4u-%02u', $this->year, $this->month)));
		$month = date('m', strtotime(sprintf('%4u-%02u', $this->year, $this->month)));
		// $events = $this->Event->findByPeriod($year, $month);
		$daysWithLink = [];

		for ($d = 1 ; $d <= 31; $d++) {
			$events = $this->Event->findByDayInCalendar($year, $month, $d);
			if (!empty($events)) {
				$daysWithLink[$d] = sprintf('/de/10/Programm.html?action=byDay&day=%04u-%02u-%02u', SELFURL, $year, $month, $d);
			}
		}

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
	}


	/**
	 * Get the calendar widget from AJAX request
	 *
	 * @access public
	 * @return void
	 */
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
