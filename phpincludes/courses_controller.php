<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Jakobus\Course;

use \Exception;

class CoursesController extends Controller {

	protected $courseId;

	public function init () {
		$this->Course = new Course ();
		$this->Course->setLanguage ($this->pageLang);
		// $this->Course->order([
		// 	'movie_position' => 'asc'
		// ]);
		$this->templatesPath = $this->templatesPath . 'courses/';
	}

	public function initActions ($action = '') {
		parent::initActions ();
		if (preg_match ('/\,([0-9]+)\.html/', $_SERVER['REQUEST_URI'], $matches)) {
			$this->courseId = (int)$matches[1];
			$this->action = 'detail';
		}
	}

	public function actionDefault () {

		$courses = $this->Course
			->filter ([
				'course_is_active' => 1
			])
			->limit ()
			->findAll ()
		;
		$this->parser->setParserVar ('courses', $courses);

		$this->content = $this->parser->parseTemplate ($this->templatesPath . 'overview.tpl');
	}


	// public function actionDetail () {
	// 	$course = $this->Course->filter([
	// 		'id' => $this->courseId
	// 	])
	// 	->findOne ();
    //
	// 	$this->parser->setMultipleParserVars ($course);
	// 	$this->content = $this->parser->parseTemplate ($this->templatesPath . 'detail.tpl');
	// }



	/**
	 * Overview of upcoming events in a given month
	 * Year and month are read from GET parameters
	 */
	public function actionOverview () {
		$currentMonth = (int)date('m');
		$currentYear = (int)date('Y');

		for ($month = 1; $month <= 12; $month++) {
			$events = $this->Course->findEventsByMonth ($currentYear, $month);

			if ( !empty ($events)) {
				$this->parser->setMultipleParserVars ([
					'month' => $month,
					'month_fmt' => strftime ('%B', strtotime (sprintf ("%04u-%02u-01", $currentYear, $month))),
				]);	

				$this->parser->setParserVar ('events', $events);
				$this->content .= $this->parser->parseTemplate ($this->templatesPath . 'events_by_month.tpl');
			}
		}
	}

	public function actionDetail () {
		$course = $this->Course->filter(['id' => $this->courseId])->findOne ();
		$this->parser->setMultipleParserVars ($course);
		$this->content = $this->parser->parseTemplate ($this->templatesPath . 'detail.tpl');
	}
}

$autoLoad = new PsrAutoloader ();
$autoLoad->addNamespace ('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new CoursesController ();
$content = $ctl->work ();
?>
