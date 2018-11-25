<?php
namespace Jakoobus;
/**
 * phpincludes/slider/homepageslider_controller.php
 *
 * @author Johannes Braun <j.braun@agentur-halma.de>
 * @package hauhs-st-jakoobus
 */

use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Jakobus\HomepageSlider;

$autoLoader = new  PsrAutoloader();
$autoLoader->addNamespace('Contentomat', INCLUDEPATHTOADMIN . 'classes');
$autoLoader->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');


class HomepagesliderController extends Controller {

	/**
	 * undocumented function
	 *
	 * @return void
	 */
	public function init()
	{
		parent::init();
		$this->HomepageSlider = new HomepageSlider();
		$this->templatesPath = PATHTOWEBROOT . 'templates/slider/';
	}
	
	/**
	 * Default action: Show slider
	 *
	 * @return void
	 */
	public function actionDefault() {

		$images = $this->HomepageSlider->getImages();
		$this->parser->setParserVar('images', $images);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'homepage_slider.tpl');
	}
	
    
}

$ctl = new HomepagesliderController();
$content = $ctl->work();
?>
