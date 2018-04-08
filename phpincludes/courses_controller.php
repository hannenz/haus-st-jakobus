<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
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
		if (preg_match ('/\,([0-9]+).html$/', $_SERVER['REQUEST_URI'], $matches)) {
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
