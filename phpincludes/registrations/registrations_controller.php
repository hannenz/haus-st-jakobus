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
		$this->parser->setMultipleParserVars($event);

		$fields = $this->Registration->getFormFields(null, ['validate' => !empty ($this->postvars)]);
		$this->parser->setMultipleParserVars($fields);

		if (!empty ($this->postvars)) {
			$data = $this->postvars;
			$data['registration_date'] = strftime('%Y-%m-%d %H:%I:%S');
			$data['registration_is_member'] = !empty($this->postvars['registration_is_member']);
			if (!$this->Registration->save ($data, ['callback' => __NAMESPACE__ . '\RegistrationsController::afterSave'])) {
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



	// public function afterSave ($success, $data, $options) {
	// 	Registration::notifyUser($data);
	// 	return $success;
	// }



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
