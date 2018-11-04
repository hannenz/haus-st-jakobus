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

class CourseCalendarWidgetController extends Controller {

	protected $Event;

	public function init() {

		$this->Calendar = new Calendar();
		$this->CmtPage = new CmtPage();

		$this->Event = new Event();
		// $this->CourseCategory = new CourseCategory ();
		// $this->CourseCategory->setLanguage ($this->pageLang);
		// $this->CourseCategory->order (['course_category_position' => 'asc']);
		// $this->templatesPath = $this->templatesPath . 'course_categories/';
	}

	public function actionDefault() {
		$year = date('Y');
		$month = date('m');
		$events = $this->Event->findByPeriod($year, $month);
		$daysWithLink = [];

		foreach ($events as $event) {

			$dayOfMonth = strftime('%d', strtotime ($event['event_begin']));
			$daysWithLink[$dayOfMonth] = sprintf('/de/10/Programm.html?action=byDay&day=%04u-%02u-%02u', SELFURL, $year, $month, $dayOfMonth);
		}
		// var_dump($daysWithLink); die();
		
		$this->Calendar->setDaysWithLink($daysWithLink);
		$calendarContent = $this->Calendar->createCalendar([
			'link' => sprintf('%s%s?year={YEAR}&month={MONTH}&day={DAY}',
				$this->CmtPage->makePageFilePath($this->Event->getOverviewPageId()),
				$this->CmtPage->makePageFileName($this->Event->getOverviewPageId())
			)
		]);
		$this->content = '<nav class="widget">' . $calendarContent . '</nav>';
	}
}

$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new CourseCalendarWidgetController();
$content = $ctl->work();
?>
