<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Jakobus\Registration;
use Jakobus\Event;

use \Exception;



class RegistrationsController extends Controller {


	/**
	 * @var integer
	 */
	protected $eventId;



	public function init () {
		$this->Registration = new Registration();
		$this->Registration->setLanguage ($this->pageLang);
		$this->Event = new Event();

		$this->templatesPath = $this->templatesPath . 'registrations/';

		if (preg_match('/\,(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
			$this->eventId = (int)$matches[1];
		}
	}



	public function actionDefault () {

		$event = $this->Event->findById($this->eventId);
		var_dump($event); die();

		

		$fields = $this->Registration->getFormFields(null, ['validate' => !empty ($this->postvars)]);
		$this->parser->setMultipleParserVars($fields);

		if (!empty ($this->postvars)) {
			if (!$this->Pilgrimpass->save ($this->postvars, ['callback' => __NAMESPACE__ . '\PilgrimpassesController::afterSave'])) {
				$this->parser->setParserVar('saveFailed', true);
			}
			else {
				return $this->changeAction('success');
			}
		}

		$this->content = $this->parser->parseTemplate($this->templatesPath . 'form.tpl');
	}



	public function afterSave ($success, $data, $options) {
		// E.g. send an email notification etc.
		return $success;
	}



	public function actionSuccess () {
		$this->parser->setMultipleParserVars ($this->postvars);
		$this->content = $this->parser->parseTemplate ($this->templatesPath . 'success.tpl');
	}
	
}



$autoLoad = new PsrAutoloader ();
$autoLoad->addNamespace ('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new RegistrationsController ();
$content = $ctl->work ();
?>
