<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Jakobus\Course;
use Jakobus\CourseCategory;
use Jakobus\Calendar;

use \Exception;

class CourseCalendarWidgetController extends Controller {

	protected $Course;

	public function init () {

		$this->Calendar = new Calendar ();

		$this->Course = new Course ();
		// $this->CourseCategory = new CourseCategory ();
		// $this->CourseCategory->setLanguage ($this->pageLang);
		// $this->CourseCategory->order (['course_category_position' => 'asc']);
		// $this->templatesPath = $this->templatesPath . 'course_categories/';
	}

	public function actionDefault () {
		$year = date('Y');
		$month = date('m');
		$courses = $this->Course->findEventsByMonth ($year, $month);
		$daysWithLink = [];

		foreach ($courses as $course) {

			$dayOfMonth = strftime ('%d', strtotime ($course['media_date_begin']));
			$daysWithLink[$dayOfMonth] = sprintf ('%s?action=byDay&day=%04u-%02u-%02u', SELFURL, $year, $month, $dayOfMonth);
		}
		// var_dump($daysWithLink); die();
		
		$this->Calendar->setDaysWithLink ($daysWithLink);
		$this->content = '<nav class="widget">' . $this->Calendar->createCalendar () . '</div>';
	}
}

$autoLoad = new PsrAutoloader ();
$autoLoad->addNamespace ('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new CourseCalendarWidgetController ();
$content = $ctl->work ();
?>
