<?php
namespace Jakobus;
/**
 * Generate a thumbnail upon upload
 *
 * @author  Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 * @version 2018-11-01
 */
use Contentomat\Image;
use Contentomat\FieldHandler;
use Contentomat\Logger;



$Image = new Image();
$FieldHandler = new FieldHandler();

$field = $FieldHandler->getField([
	'tableName' => 'jakobus_courses',
	'fieldName' => 'course_image'
]);

$imageSourcePath = $_FILES['course_image_newfile']['tmp_name'];
$thumbnailDestPath = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . 'thumbnails' . DIRECTORY_SEPARATOR . $cmtTableDataRaw['course_image'];
$squareThumbnailDestPath = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . 'thumbnails' . DIRECTORY_SEPARATOR . 'square'. DIRECTORY_SEPARATOR . $cmtTableDataRaw['course_image'];

$info = getimagesize($imageSourcePath);
switch ($info['mime']) {
	case 'image/jpeg':
		$sourceImageType = 'jpg';
		break;
	case 'image/png':
		$sourceImageType = 'png';
		break;
	case 'image/gif':
		$sourceImageType = 'gif';
		break;
	default:
		$sourceImageType = null;
		break;
}

if ($sourceImageType != null) {

	Logger::log(sprintf("Creating thumbnail: %s", $thumbnailDestPath));
	$check = $Image->createThumbnail([
		'sourceImage' => $imageSourcePath,
		'sourceImageType' => $sourceImageType,
		'destinationImage' => $thumbnailDestPath,
		'width' => 320,
		'preserveRatio' => true
	]);
	if (!$check) {
		die ($Image->getErrorMessage());
	}

	Logger::log(sprintf("Creating thumbnail: %s", $squareThumbnailDestPath));
	$Image->createSquareThumbnail($imageSourcePath, $squareThumbnailDestPath, 320);

	Logger::log("Resizing image");
	$Image->createThumbnail([
		'sourceImage' => $imageSourcePath,
		'sourceImageTpye' => $sourceImageTpye,
		'destinationImage' => $imageSourcePath,
		'width' => 1024,
		'preserveRatio' => true
	]);
}

?>
