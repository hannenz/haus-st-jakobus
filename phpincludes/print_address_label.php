<?php
namespace Jakobus;

use \Jakobus\Pilgrimpass;
use \Contentomat\Contentomat;
use \Contentomat\Controller;

class AdressLabelController extends Controller {

	/**
	 *	@var Integer
	*/
	public $pilgrimpassId;



	public function init() {

		$id = $_REQUEST['id'];
		if (is_array($id)) {
			$this->pilgrimpassId = $id[0]; 
		}
		else {
			$this->pilgrimpassId = $id;
		}
		$this->cmt = Contentomat::getContentomat();
	}



	public function actionDefault() {
		$button = sprintf('<a class="cmtButton" href="/do-something/%u">Adress-Etikett drucken</a>', $this->pilgrimpassId);
		$this->cmt->setVar ('addressLabelButton', $button);
	}
}

$ctl = new AdressLabelController();
$ctl->work();
?>
