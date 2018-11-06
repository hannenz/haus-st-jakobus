<?php 
namespace Jakobus;

class CourseParser extends \Contentomat\Parser {
	
	protected $images = array();
	protected $imagesProcessed = array();
	protected $currentImageNr = 1;
	protected $templateContainedImage = false;
	
	public function __construct() {
		parent::__construct();
		
		$this->debug = new \Contentomat\Debug();
	}
	
	public function macro_IMAGESRC($imageNr, $params) {

		$this->templateContainedImage = true;
		$replaceData = '';
		$imageNr = intval($imageNr);
		
		// is an image number given and wasn't this image shown before and is this number vali (does the image exist?)
// 		if (in_array($imageNr, $this->imagesProcessed) || ($imageNr && !isset($this->images[$imageNr]))) {
// 			return $replaceData;
// 		}
		
		// no image number? Then get one!
		if (!$imageNr) {
			$imageNr = $this->currentImageNr; //$this->getNextValidImageNr();
		}
		$this->d('src: ' . $imageNr);
		
		$replaceData = $this->images[$imageNr]['src'];
		
		$this->imagesProcessed[] = $imageNr;
		$this->currentImageNr = $imageNr+1;
		
		if ($params[1]) {
			array_shift($params);	//???
			$replaceData = $this->processMacroValue(array_shift($params), $replaceData, $params);
		}
	
		return $replaceData;
	}

	public function macro_IMAGETITLE($imageNr, $params) {
	
		$imageNr = intval($imageNr);
		$this->templateContainedImage = true;
		
		// no image number? Then get one!
		if (!$imageNr) {
			$imageNr = $this->currentImageNr;
		}
		$replaceData = $this->images[$imageNr]['caption'];
		$this->d('caption: ' . $imageNr);
		
		if ($params[1]) {
			array_shift($params);	//???
			$replaceData = $this->processMacroValue(array_shift($params), $replaceData, $params);
		}
	
		return $replaceData;
	}
	
	public function macro_IMAGEDESCRIPTION($imageNr, $params) {

		$imageNr = intval($this->parse($imageNr));
		$this->templateContainedImage = true;
	
		// no image number? Then get one!
		if (!$imageNr) {
			$imageNr = $this->currentImageNr;
		}
		
		$replaceData = $this->images[$imageNr]['description'];
		$this->d('desc: ' . $imageNr);
		if ($params[1]) {
			array_shift($params);	//???
			$replaceData = $this->processMacroValue(array_shift($params), $replaceData, $params);
		}
	
		return $replaceData;
	}

	public function macro_IMAGEALT($imageNr, $params) {
	
		$imageNr = intval($imageNr);
		
		// no image number? Then get one!
		if (!$imageNr) {
			$imageNr = $this->currentImageNr;
		}
		
		$replaceData = htmlentities($this->images[$imageNr]['alt']);
	
		if ($params[1]) {
			array_shift($params);	//???
			$replaceData = $this->processMacroValue(array_shift($params), $replaceData, $params);
		}
	
		return $replaceData;
	}
	
	public function macro_HASIMAGETITLE($imageNr, $params) {
		
		$imageNr = intval($imageNr);
		
		// no image number? Then get one!
		if (!$imageNr) {
			$imageNr = $this->currentImageNr;
		}

		return (bool)$this->images[$imageNr]['caption'];
	}
	
	public function macro_NEXTTEMPLATE($value, $params) {
		
		$this->imagesProcessed[] = $this->currentImageNr;
		sort($this->imagesProcessed);
		
		if ($this->templateContainedImage) {
			//$this->currentImageNr++; // = $this->getNextValidImageNr();
		}
		$this->templateContainedImage = false;
		
		return '';
	}
	
	public function macro_PREVIMAGENR($imagesBack) {
	
		if (!$imagesBack) {
			$imagesBack = 1;
		}
		$prevImageNr = $this->currentImageNr - (int)$imagesBack;

		if ($prevImageNr <=0 ) {
			return 1;
		} else {
			return (int)$prevImageNr;
		}
	}
	
	public function setImages($images) {
		
		if (!is_array($images)) {
			return false;
		}
		
		$key = 1;
		
		foreach ($images as $image) {
			
			$this->images[$key++] = array(
				'src' => $image['media_image_file_internal'],
				'alt' => $image['media_title'],
				'caption' => $image['media_title'],
				'description' => $image['media_description']
			);
		}
		
		return true;
	}
	
	protected function getNextValidImageNr() {
		
		foreach ($this->images as $imageNr => $imageData) {
			
			if (!in_array($imageNr, $this->imagesProcessed)) {
				return $imageNr;
			}
		}
		return 0;
	}
	
	private function d($message) {
		$this->debug->info($message);
	}
}

