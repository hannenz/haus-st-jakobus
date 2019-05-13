<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\CmtPage;
use Contentomat\Debug;
use Jakobus\Registration;
use Jakobus\Event;

use \Exception;

define('REGISTRATION_SUCCESS_PAGE_ID', 85);

ini_set('display_errors', true);
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);


class RegistrationsController extends Controller {


	/**
	 * @var integer
	 */
	protected $eventId;


	/**
	 * @var Object
	 */
	protected $CmtPage;


	public function init () {
		$this->Registration = new Registration();
		$this->Registration->setLanguage ($this->pageLang);
		$this->Event = new Event();
		$this->CmtPage = new CmtPage();

		$this->templatesPath = $this->templatesPath . 'registrations/';

		if (preg_match('/\,(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
			$this->eventId = (int)$matches[1];
		}
	}



	public function actionDefault () {

		$event = $this->Event->findById($this->eventId);
		$this->parser->setMultipleParserVars($event);

		$fields = $this->Registration->getFormFields(null, ['validate' => !empty ($this->postvars)]);
		$this->parser->setMultipleParserVars($fields);

		if (!empty($this->postvars)) {
			$data = $this->postvars;
			foreach($data as $key => $value) {
				$data[$key] = trim($value);
			}
			$data['registration_date'] = strftime('%Y-%m-%d %H:%I:%S');
			$data['registration_is_member'] = !empty($this->postvars['registration_is_member']);
			if (!$this->Registration->save ($data)) {
				$this->parser->setParserVar('saveFailed', true);
			}
			else {
				$this->Registration->notifyUser(array_merge($data, $event));
				$this->Registration->notifyAdmin(array_merge($data, $event));
				return $this->changeAction('success');
			}
		}

		$this->content = $this->parser->parseTemplate($this->templatesPath . 'form.tpl');
	}



	public function actionSuccess () {
		$url = sprintf('%s%s', $this->CmtPage->makePageFilePath(REGISTRATION_SUCCESS_PAGE_ID), $this->CmtPage->makePageFileName(REGISTRATION_SUCCESS_PAGE_ID));

		header('Location: '.$url);
		// $this->parser->setMultipleParserVars ($this->postvars);
		// $this->content = $this->parser->parseTemplate ($this->templatesPath . 'success.tpl');
	}
	
}



$autoLoad = new PsrAutoloader ();
$autoLoad->addNamespace ('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new RegistrationsController ();
$content = $ctl->work ();
?>
