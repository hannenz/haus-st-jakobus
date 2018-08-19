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
		$fields = $this->Pilgrimpass->getFormFields ();
		$this->parser->setMultipleParserVars ($fields);

		$this->content = $this->parser->parseTemplate ($this->templatesPath . 'form.tpl');
	}
}

$autoLoad = new PsrAutoloader ();
$autoLoad->addNamespace ('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new PilgrimpassesController ();
$content = $ctl->work ();
?>
