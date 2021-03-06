<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Contentomat\TableMedia;
use Contentomat\TableDataLayout;
use Jakobus\Course;
use Jakobus\Event;
use Jakobus\CourseCategory;
use Jakobus\CourseParser;

use \Exception;


class CoursesController extends Controller {

	protected $courseId;


	/**
	 * @var Jakobus\Course
	 */
	protected $Course;

	/**
	 * @var Jakobus\Event
	 */
	protected $Event;

	/**
	 * @var Contentomat\TableDataLayout
	 */
	protected $TablelDataLayout;

	/**
	 * @var Contentomat\TableMedia
	 */
	protected $TablelMedia;


	public function init() {

		$this->Course = new Course();
		$this->Event = new Event();
		$this->TableDataLayout = new TableDataLayout();
		$this->TableMedia = new TableMedia();
		$this->parser = new CourseParser();

		$this->Course->setLanguage($this->pageLang);

		$this->CourseCategory = new CourseCategory();
		$this->CourseCategory->setLanguage($this->pageLang);
		$this->CourseCategory->order(['course_category_position' => 'asc']);

		$this->templatesPath = $this->templatesPath . 'courses/';
	}

	public function initActions($action = '') {
		parent::initActions();
		// $this->action = 'overview';
		if (preg_match('/\,([0-9]+)\.html/', $_SERVER['REQUEST_URI'], $matches)) {
			$this->courseId = (int)$matches[1];
			$this->action = 'detail';
		}

	}

	public function actionDefault() {

		$categories = $this->CourseCategory->findAll();

		// foreach ($categories as $category) {
        //
		// 	$courses = $this->Course
		// 		->filter([
		// 			'course_is_active' => 1
		// 		])
		// 		->limit()
		// 		->findAll(['fetchAssociations' => false])
		// 	;
		// 	$data[] = array_merge($category, $courses);
		// }
		// var_dump($data); die();
		// 	

		// $this->parser->setParserVar('courses', $courses);
		$this->parser->setParserVar('categories', $categories);

		$this->content = $this->parser->parseTemplate($this->templatesPath . 'overview.tpl');
	}

	public function actionListByCategory() {
		$categoryId = $this->getvars ['categoryId'];
		$category = $this->CourseCategory->findById($categoryId);

		$courses = $this->Course
			->filter([
				'course_is_active' => 1,
				'course_category_id' => $categoryId
			])
			->limit()
			->findAll(['fetchAssociations' => false]);

		$category['Courses'] = $courses;
		$categories = [ $category ];
		$this->parser->setParserVar('categories', $categories);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'overview.tpl');
	}


	/**
	 * Courses by category
	 */
	public function actionByCategory() {

		$categories = $this->CourseCategory->findAll([
			'fetchAssociations' => true
		]);
		$this->parser->setParserVar('categories', $categories);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'by_category.tpl');
	}



	public function actionDetail() {

		$dataLayout = $this->TableDataLayout->getWithTemplates($this->Course->getTableId(), $this->courseId);
		// Only set table data layout if at least one is used, else 
		// we just use the default "static" layout. (see dateil.tpl)
		if (!empty($dataLayout['templates'][0])) {
			$this->parser->setParserVar('templates', $dataLayout['templates']);
			$courseImages = $this->TableMedia->getMedia([
				'tableId' => $this->Course->getTableId(),
				'entryId' => $this->courseId,
				'mediaType' => 'image'
			]);
			$this->parser->setImages($courseImages);
		}

		$course = $this->Course->filter([
			'id' => $this->courseId
		])
		->findOne();

		define('COURSE_TITLE', $course['course_title']);

		$course['course_events'] = $this->Event->filter([
			'event_course_id' => $course['id'],
			'event_begin >' => "'" . strftime("%Y-%m-%d 00:00:00") . "'"
		])
		->order(['event_begin' => 'ASC'])
		->findAll();

		define('COURSETITLE', $course['course_title']);
		define('MOODIMAGE', '/media/courses/'.$course['course_image']);


		$this->parser->setMultipleParserVars($course);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'detail.tpl');
	}
}

$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new CoursesController();
$content = $ctl->work();
?>
