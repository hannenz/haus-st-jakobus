<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Jakobus\Course;
use Jakobus\CourseCategory;

use \Exception;

class CourseCategoryWidgetsController extends Controller {


	public function init () {

		$this->CourseCategory = new CourseCategory ();
		$this->CourseCategory->setLanguage ($this->pageLang);
		$this->CourseCategory->order (['course_category_position' => 'asc']);

		$this->templatesPath = $this->templatesPath . 'course_categories/';
	}

	public function actionDefault () {
		$course_categories = $this->CourseCategory
			->filter([
			])
			->findAll ();
		
		$this->parser->setParserVar ('course_categories', $course_categories);
		$this->content = $this->parser->parseTemplate ($this->templatesPath . 'course_categories_widget.tpl');
	}
}

$autoLoad = new PsrAutoloader ();
$autoLoad->addNamespace ('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new CourseCategoryWidgetsController ();
$content = $ctl->work ();
?>
