<?php
namespace Jakobus;

use Contentomat\ApplicationController;
use Contentomat\Parser;
use Contentomat\PsrAutoloader;
use Contentomat\Form;
use Jakobus\Event;
use Jakobus\Course;

$autoLoader = new PsrAutoloader();
$autoLoader->addNamespace('Contentomat', INCLUDEPATHTOADMIN . 'classes');
$autoLoader->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');

class RegistrationsOverviewController extends ApplicationController {

	public function init() {
		parent::init();
		$this->Form = new Form();
		$this->Event = new Event();
		$this->Course = new Course();
	}

	public function actionDefault() {
		$eventId = $_REQUEST['eventId'];
		$courseId = $_REQUEST['courseId'];

		$events = $this->Event->findAll(['fetchAssociations' => false]);
		$eventAliases = [];
		foreach ($events as $event) {
			$eventAliases[] = sprintf('%s [%s]: %s - %s', $event['event_title'], $event['course_title'], $event['event_begin_fmt'], $event['event_end_fmt']);
		}

		$eventSelect = $this->Form->select([
			'values' => array_keys($events),
			'aliases' => $eventAliases,
			'optionsOnly' => true,
			'selected' => $eventId
		]);


		$courses = $this->Course->findAll(['fetchAssociations' => false]);
		$courseAliases = [];
		foreach ($courses as $course) {
			$courseAliases[] = $course['course_title'];
		}
		$courseSelect = $this->Form->select([
			'values' => array_keys($courses),
			'aliases' => $courseAliases,
			'optionsOnly' => true,
			'selected' => $courseId
		]);

		if (!empty($eventId)) {
			$this->cmt->setVar('cmtAddQuery', sprintf(' WHERE registration_event_id=%u', $eventId));
		}

		if (!empty($courseId)) {
			$this->cmt->setVar('cmtAddQuery', sprintf('SELECT * FROM jakobus_registrations LEFT JOIN jakobus_events ON jakobus_registrations.registration_event_id=jakobus_events.id WHERE event_course_id=%u', $courseId));
		}

		$Parser = new Parser();
		$Parser->setParserVar('eventSelect', $eventSelect);
		$Parser->setParserVar('courseSelect', $courseSelect);
		$this->content = $Parser->parseTemplate(PATHTOWEBROOT . "templates/registrations/registrations_overview.tpl");
	}
}

$ctl = new RegistrationsOverviewController();
$content .= $ctl->work();
?>
