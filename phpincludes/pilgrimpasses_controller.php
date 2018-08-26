<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Debug;
use Jakobus\Pilgrimpass;

use \Exception;



class PilgrimpassesController extends Controller {



	public function init () {
		$this->Pilgrimpass = new Pilgrimpass ();
		$this->Pilgrimpass->setLanguage ($this->pageLang);

		$this->templatesPath = $this->templatesPath . 'pilgrimpasses/';
	}



	public function actionDefault () {
		$fields = $this->Pilgrimpass->getFormFields (null, ['validate' => !empty ($this->postvars)]);
		$this->parser->setMultipleParserVars ($fields);

		if (!empty ($this->postvars)) {
			if (!$this->Pilgrimpass->save ($this->postvars, [ 'callback' => __NAMESPACE__ . '\PilgrimpassesController::afterSave'])) {
				$this->parser->setParserVar ('saveFailed', true);
			}
			else {
				return $this->changeAction ('success');
			}
		}

		$this->content = $this->parser->parseTemplate ($this->templatesPath . 'form.tpl');
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
$ctl = new PilgrimpassesController ();
$content = $ctl->work ();
?>
