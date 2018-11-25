<?php
namespace Jakobus;

use Contentomat\PsrAutoloader;
use Contentomat\Gallery\Gallery;


$autoLoader = new PsrAutoloader();
$autoLoader->addNamespace('Contentomat\Gallery', INCLUDEPATHTOADMIN . 'classes/app_gallery');


define('HOMEPAGESLIDER_CATEGORY_ID', 4);

class  HomepageSlider extends Gallery {

	
	public function __construct() {
		parent::__construct();
	}


	public function getImages() {

		$images = $this->getImagesInCategory(HOMEPAGESLIDER_CATEGORY_ID, []);
		return $images;
	}
}
?>
