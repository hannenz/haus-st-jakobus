<?php
/**
 * After deleting a course, also delete
 * corresponding uploaded images and thumbnails
 *
 * @author Johannes Braun
 * @package haus-st-jakobus
 * @version 2018-11-03
 */
namespace Jakobus;

use Contentomat\FieldHandler;
use Contentomat\Logger;

$FieldHandler = new FieldHandler();

$field = $FieldHandler->getField([
	'tableName' => 'jakobus_courses',
	'fieldName' => 'course_image'
]);

$file = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . 'thumbnails' . DIRECTORY_SEPARATOR . 'square' . DIRECTORY_SEPARATOR . $cmtTableDataRaw['course_image'];
$check = @unlink($file);
Logger::log(sprintf("Deleting file: %s: %s",  $file, $check ? "ok" : "failed"));

$file = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . 'thumbnails' . DIRECTORY_SEPARATOR . $cmtTableDataRaw['course_image'];
$check = @unlink($file);
Logger::log(sprintf("Deleting file: %s: %s",  $file, $check ? "ok" : "failed"));

$file = PATHTOWEBROOT . $field['cmt_option_upload_dir'] . $cmtTableDataRaw['course_image'];
$check = @unlink($file);
Logger::log(sprintf("Deleting file: %s: %s",  $file, $check ? "ok" : "failed"));
?>
