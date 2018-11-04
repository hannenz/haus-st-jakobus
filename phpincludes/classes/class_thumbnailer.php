<?php
namespace Jakobus;
/**
 * Generate thumbnails upon upload
 *
 * @author  Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 * @version 2018-11-01
 */
use Contentomat\Contentomat;
use Contentomat\Image;
use Contentomat\FieldHandler;
use Contentomat\Logger;

class Thumbnailer extends \Contentomat\Image {
	/**
	 * @var Contentomat\FieldHandler
	 */
	protected $FieldHandler;

	/**
	 * @var \Contentomat\Contentomat
	 */
	private $Cmt;

	/**
	 * @var Array
	 */
	private $fieldInfo;


	private $tableName;
	private $fieldName;


	public function __construct($tableName, $fieldName) {
		parent::__construct();


		$this->FieldHandler = new FieldHandler();
		$this->Cmt = Contentomat::getContentomat();

		$this->errorMessage = '';
		$this->tableName = $tableName;
		$this->fieldName = $fieldName;
	}


	/**
	 * Get an image file's type
	 *
	 * @param string 		file path
	 * @return string 		type string (jpg|png|gif) or null
	 */
	public function getImageType($file) {
		$info = getimagesize($file);
		switch ($info['mime']) {
			case 'image/jpeg':
				$type = 'jpg';
				break;
			case 'image/png':
				$type = 'png';
				break;
			case 'image/gif':
				$type = 'gif';
				break;
			default:
				$this->errorMessage = sprintf('Image file "%s" has an unknown or unsupported image file type (%s)', $file, $info['mime']);
				$type = null;
				break;
		}

		return $type;
	}

	public function createThumbnails($thumbnails) {
		$this->fieldInfo = $this->FieldHandler->getField([
			'tableName' => $this->tableName,
			'fieldName' => $this->fieldName
		]);
		if (empty($this->fieldInfo)) {
			$this->errorMessage = sprintf('Could not get field info for %s.%s', $this->tableName, $this->fieldName);
			return false;
		}
		
		$sourceImage = $_FILES[$this->fieldInfo['cmt_fieldname'].'_newfile']['tmp_name'];
		$sourceImageType = $this->getImageType($sourceImage);

		if ($sourceImageType == null) {
			return false;
		}

		$success = true;
		foreach ($thumbnails as $options) {
			$thumbnailDestPath = $this->Cmt->cleanPath(join(DIRECTORY_SEPARATOR, [PATHTOWEBROOT , $this->fieldInfo['cmt_option_upload_dir'], $options['dir'] , $_FILES[$this->fieldInfo['cmt_fieldname'].'_newfile']['name']]));
			
			if ($options['square']) {

				Logger::log(sprintf("Creating square thumbnail: %s", $thumbnailDestPath));
				$this->createSquareThumbnail($sourceImage, $thumbnailDestPath, $options['width']);
			}
			else {
				Logger::log(sprintf("Creating thumbnail: %s", $thumbnailDestPath));
				$success = $this->createThumbnail([
					'sourceImage' => $sourceImage,
					'sourceImageType' => $sourceImageType,
					'destinationImage' => $thumbnailDestPath,
					'width' => $options['width'],
					'preserveRatio' => true
				]);
				if (!$success) {
					break;
				}
			}
		}

		// Logger::log("Resizing image");
		// $success = $this->createThumbnail([
		// 	'sourceImage' => $sourceImage,
		// 	'sourceImageTpye' => $sourceImageTpye,
		// 	'destinationImage' => $sourceImage,
		// 	'width' => 1024,
		// 	'preserveRatio' => true
		// ]);
		// if (!$success) {
		// 	return false;
		// }

		return $success;
	}
}
?>
