<?php
/**
 * @author  Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 * @version 2018-11-01
 */
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\Image;
use Contentomat\FieldHandler;
use Contentomat\Logger;



/**
 * @class Thumbnailer
 * @extends \Contentomat\Image
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @description Generate thumbnails upon upload
 * @usage
 *
 * In CodeManager add a callback script like this:
 *
 * ```
 * <?php
 * namespace FooBar;
 * 
 * use FooBar\Thumbnailer;
 * use Contentomat\PsrAutoloader;
 * 
 * $autoLoad = new PsrAutoloader();
 * $autoLoad->addNamespace('FooBar', PATHTOWEBROOT . "phpincludes/classes");
 * 
 * $thumbnailer = new Thumbnailer('your_table_name', 'your_upload_field_name');
 * $success = $thumbnailer->createThumbnails([
 * 		[
 * 			'width' => 480,
 * 			'dir' => 'thumbnails'
 * 		],
 * 		[
 * 			'width' => 320,
 * 			'dir' => 'thumbnails/square',
 * 			'square' => true
 * 		]
 * ]);
 * ?>
 * ```
 *
 * Pass the table's and field's name to the Constructor.
 * Pass an array of thumbnail parameters to the methon `createThumbnails`
 * Thumbnailer class can generate multiple thumbnails at once, pass an  array
 * shown above...
 */

class Thumbnailer extends \Contentomat\Image {
	/**
	 * @var \Contentomat\FieldHandler
	 */
	protected $FieldHandler;

	/**
	 * @var \Contentomat\Contentomat
	 */
	private $Cmt;

	/**
	 * @var String
	 */
	private $tableName;

	/**
	 * @var String
	 */
	private $fieldName;

	/**
	 * @var Boolean
	 */
	protected $log;



	public function __construct($tableName, $fieldName, $options = []) {
		parent::__construct();

		$defaultOptions = [
			'log' => true
		];
		$options = array_merge($defaultOptions, $options);
		$this->log = $options['log'];


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
		$fieldInfo = $this->FieldHandler->getField([
			'tableName' => $this->tableName,
			'fieldName' => $this->fieldName
		]);
		if (empty($fieldInfo)) {
			$this->errorMessage = sprintf('Could not get field info for %s.%s', $this->tableName, $this->fieldName);
			return false;
		}


		$cmtFileName = $this->Cmt->getVar('cmt_filename');
		$cmtUploadPath = $this->Cmt->getVar('cmt_uploadpath');
		$cmtSourcePath = $this->Cmt->getVar('cmt_sourcepath');

		
		$sourceImage = $cmtSourcePath;
		$sourceImageType = $this->getImageType($sourceImage);

		if ($sourceImageType == null) {
			return false;
		}

		$success = true;
		foreach ($thumbnails as $options) {
			$thumbnailDestPath = $this->Cmt->cleanPath(join(DIRECTORY_SEPARATOR, [PATHTOWEBROOT , $fieldInfo['cmt_option_upload_dir'], $options['dir'] , $cmtFileName]));
			
			if ($this->log) {
				Logger::log(sprintf("Creating%s thumbnail: %s",
					$options['square'] ? ' square' : '',
					$thumbnailDestPath
				));
			}
			if ($options['square']) {
				$this->createSquareThumbnail($sourceImage, $thumbnailDestPath, $options['width']);
			}
			else {
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

		return $success;
	}
}
?>
