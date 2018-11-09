<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\ApplicationController;
use Jakobus\Course;
use Jakobus\Event;
use Jakobus\Registration;
use Jakobus\CourseCategory;

error_reporting(E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
ini_set('display_errors', true);

$autoLoader = new PsrAutoloader();
$autoLoader->addNamespace('Jakobus', PATHTOWEBROOT."phpincludes/classes");

class AppCoursemanager extends ApplicationController {

	protected $Course;
	protected $CourseCategory;
	protected $Event;
	protected $Registration;

	public function init() {

		parent::init();

		$this->Course = new Course();
		$this->CourseCategory = new CourseCategory();
		$this->Event = new Event();
		$this->Registration = new Registration();
		$this->parser->setUserTemplateBasePath(PATHTOWEBROOT.'templates/courses/app_coursemanager/');
	}

	/**
	 *
	 * | Veranstaltungen | Anmeldungen | Kategorien | 
	 * --------------------------------------------------------
	 * | 
	 */
	public function actionDefault() {
		$query = <<<EOS
			SELECT Course.*, Event.*
			FROM jakobus_events AS Event
			LEFT JOIN jakobus_courses AS Course
				ON Event.event_course_id = Course.id
			ORDER BY Event.event_begin ASC
EOS;
		if ($this->db->query($query) !== 0) {
			die (sprintf("Query failed: %s: %s" , $query, $this->db->getLastError()));
		}
		// $events = $this->db->getAll();
		$pastEvents = $this->Event->getPast();
		$upcomingEvents = $this->Event->getUpcoming();

		foreach ($pastEvents as &$event) {
			$event['registrations'] = $this->Registration->filter([
				'registration_event_id' => $event['id']
			])->findAll();
			$event['registrations_count'] = count($event['registrations']);
		}

		foreach ($upcomingEvents as &$event) {
			$event['registrations'] = $this->Registration->filter([
				'registration_event_id' => $event['id']
			])->findAll();
			$event['registrations_count'] = count($event['registrations']);
		}

		$this->parser->setMultipleParserVars(compact('pastEvents', 'upcomingEvents'));
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'default.tpl');
	}
}

$ctl = new AppCourseManager();
$content .= $ctl->work();
?>
