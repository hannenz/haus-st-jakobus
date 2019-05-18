<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\Controller;
use Contentomat\Session;

class CartController extends Controller {

	private $Session;

	public function init() {
		$this->cmt = Contentomat::getContentomat();
		$this->Session = $this->cmt->getSession();
		$this->templatesPath .= 'pilgrimpasses/';
	}
	

	public function actionDefault() {
		$this->content = "Warenkorb";
		$pilgrimpasses = $this->Session->getSessionVar('pilgrimpasses');
		$this->parser->setParserVar('pilgrimpasses', $pilgrimpasses);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'cart.tpl');
	}	
}

$ctl = new CartController();
$content = $ctl->work();
?>
