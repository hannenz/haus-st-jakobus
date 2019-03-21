<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\ApplicationController;
use Contentomat\FileHandler;
use Jakobus\Course;
use Jakobus\Event;
use Jakobus\Registration;
use Jakobus\CourseCategory;

ini_set('display_errors', true);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$autoLoader = new PsrAutoloader();
$autoLoader->addNamespace('Jakobus', PATHTOWEBROOT."phpincludes/classes");

class AppCoursemanager extends ApplicationController {

	protected $FileHandler;
	protected $Course;
	protected $CourseCategory;
	protected $Event;
	protected $Registration;

	public function init() {

		parent::init();

		$this->FileHandler = new FileHandler();
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

	/**
	 * Export upcoming registrations to CSV
	 *
	 * @return void
	 */
	public function actionExportCsv() {

		$registrations = [];
		$upcomingEvents = $this->Event->getUpcoming();
		foreach ($upcomingEvents as $event) {
			$_registrations = $this->Registration->filter([
				'registration_event_id' => $event['id']
			])->findAll();
			foreach ($_registrations as $_registration) {
				$registrations[] = array_merge($event, $_registration);
			}
		}


		$lines = [ "ID,Anmelde-Datum,Anrede,Vorname,Nachname,Geburtstag,Anschrift,PLZ,Stadt,Telefon,E-Mail,Mitglied im Förderverein,Veranstaltungs-ID,Veranstaltung,Kurs\n" ];
		foreach ($registrations as $registration) {
			$lines[] = sprintf("%u,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",%u,\"%s\",\"%s\"\n",
				$registration['id'],
				strftime('%d.%m.%Y %H:%M', strtotime($registration['registration_date'])),
				$registration['registration_salutation'],
				$registration['registration_firstname'],
				$registration['registration_lastname'],
				strftime('%d.%m.%Y', strtotime($registration['registration_birthday'])),
				$registration['registration_street_address'],
				$registration['registration_zip'],
				$registration['registration_city'],
				$registration['registration_phone'],
				$registration['registration_email'],
				($registration['registration_is_member'] != 0) ? "ja" : "nein",
				$registration['registration_event_id'],
				$registration['event_title'],
				$registration['course_title']
			);
		}

		$tmpFile = tempnam(PATHTOTMP, 'reg');
		$handle = fopen($tmpFile, "w");
		foreach ($lines as $line) {
			fwrite($handle, $line);
		}
		fclose($handle);


		$this->FileHandler->handleDownload([
			'downloadFile' => $tmpFile,
			'downloadFileAlias' => sprintf('Anmeldungen_%s.csv', strftime('%Y-%m-%d-%H%M')),
			'deleteFile' => true
		]);
	}

	public function actionUpdateSeatsTaken() {
		$this->isAjax = true;
		$this->isJson = true;

		$success = $this->Event->save($this->postvars, [
			'validate' => false
		]);

		$this->content = [
			'success' => $success
		];
	}
}

$ctl = new AppCourseManager();
$content .= $ctl->work();
?>
