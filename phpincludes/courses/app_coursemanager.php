<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\ApplicationController;
use Contentomat\FileHandler;
use Contentomat\Form;
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
	protected $Form;

	protected $type;

	public function init() {

		parent::init();

		$this->FileHandler = new FileHandler();
		$this->Form = new Form();
		$this->Course = new Course();
		$this->CourseCategory = new CourseCategory();
		$this->Event = new Event();
		$this->Registration = new Registration();
		$this->parser->setUserTemplateBasePath(PATHTOWEBROOT.'templates/courses/app_coursemanager/');

		$this->type = $_REQUEST['type'];

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$this->isAjax = true;
		}
	}

	public function initActions($action = '') {
		if (isset($_REQUEST['action'])) {
			$this->action = $_REQUEST['action'];
			return;
		}

		parent::initActions($action);
	}

	/**
	 *
	 * | Veranstaltungen | Anmeldungen | Kategorien | 
	 * --------------------------------------------------------
	 * | 
	 */
	public function actionDefault() {
// 		$query = <<<EOS
// 			SELECT Course.*, Event.*
// 			FROM jakobus_events AS Event
// 			LEFT JOIN jakobus_courses AS Course
// 				ON Event.event_course_id = Course.id
// EOS;
// 		if (!empty($this->type)) {
// 			$query .= sprintf(" WHERE Event.event_is_soiree=%u ", ($this->type == 'soiree') ? 1 : 0);
// 		}
//
// 		$query .= " ORDER BY Event.event_begin ASC";
//
// 		if ($this->db->query($query) !== 0) {
// 			die (sprintf("Query failed: %s: %s" , $query, $this->db->getLastError()));
// 		}
		// $events = $this->db->getAll();
		$filter = [];
		if (!empty($this->type)) {
			$filter['event_is_soiree'] = ($this->type == 'soiree') ? 1 : 0;
		}

		$pastEvents = $this->Event->getPast($filter);
		$upcomingEvents = $this->Event->getUpcoming(0, $filter);

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

		$filterByTypeSelect = $this->Form->select([
			'values' => [
				'',
				'soiree',
				'not-soiree'
			],
			'aliases' => [
				'Alle',
				'Nur Abendveranstaltungen',
				'Nur Nicht-Abendveranstaltungen'
			],
			'optionsOnly' => true,
			'selected' => $this->type
		]);

		$this->parser->setParserVar('filterByTypeSelect', $filterByTypeSelect);
		$this->parser->setMultipleParserVars(compact('pastEvents', 'upcomingEvents'));
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'default.tpl');
	}

	/**
	 * Export upcoming registrations to CSV
	 *
	 * @return void
	 */
	public function actionExportCsv() {

		$begin = isset($_REQUEST['export_range_begin']) ? $_REQUEST['export_range_begin'] : '1970-01-01';
		$end = isset($_REQUEST['export_range_end']) ? $_REQUEST['export_range_end'] : '2199-12-31';

		// $events = $this->Event->getInRangeWithRegistrations($exportRangeBegin, $exportRangeEnd);
        //
		// $registrations = [];
		// foreach ($events as $event) {
		// 	$_registrations = $this->Registration->filter([
		// 		'registration_event_id' => $event['id']
		// 	])->findAll();
		// 	foreach ($_registrations as $_registration) {
		// 		$registrations[] = array_merge($event, $_registration);
		// 	}
		// }
        //

		$registrations = $this->Registration->getInRange($begin, $end);

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
			'downloadFileAlias' => sprintf('haus_st_jakobus_Anmeldungen_von_%s_bis_%s_stand_%s.csv', $begin, $end, strftime('%Y-%m-%d-%H%M')),
			'deleteFile' => true
		]);
	}

	public function actionUpdateSeatsTaken() {
		$this->isJson = $this->isAjax;

		$success = $this->Event->save($this->postvars, [
			'validate' => false
		]);

		if ($this->isAjax) {
			$this->content = [
				'success' => $success,
				'event_seats_taken' => $this->Event->getFieldValue($this->postvars['id'], 'event_seats_taken')
			];
		}
		else {
			$this->changeAction('default');
		}
	}

}

$ctl = new AppCourseManager();
$content .= $ctl->work();
?>
