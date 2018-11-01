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

$imageSourcePath = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . $cmtTableDataRaw['course_image'];
$thumbnailDestPath = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . 'thumbnails' . DIRECTORY_SEPARATOR . $cmtTableDataRaw['course_image'];
$squareThumbnailDestPath = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . 'thumbnails' . DIRECTORY_SEPARATOR . 'square'. DIRECTORY_SEPARATOR . $cmtTableDataRaw['course_image'];


Logger::log("Creating thumbnail");
$Image->createThumbnail([
	'sourceImage' => $imageSourcePath,
	'destinationImage' => $thumbnailDestPath,
	'width' => 320,
	'preserveRatio' => true
]);

Logger::log("Creating square thumbnail");
$Image->createSquareThumbnail($imageSourcePath, $squareThumbnailDestPath, 320);

Logger::log("Resizing image");
$Image->createThumbnail([
	'sourceImage' => $imageSourcePath,
	'destinationImage' => $imageSourcePath,
	'width' => 1024,
	'preserveRatio' => true
]);
?>
