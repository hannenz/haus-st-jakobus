<?php
namespace Jakobus;

use Jakobus\Event;
use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Logger;
use Contentomat\FieldHandler;

Logger::log('Executing event_before_save.php');


$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');

$cmt = Contentomat::getContentomat();
$Event = new Event();
$FieldHandler = new FieldHandler();

$validationErrors = $Event->validate($cmtTableDataRaw);
if (count($validationErrors) > 0) {
	$msg = '';
	foreach ($validationErrors as $validationError) {
		foreach ($validationError as $fieldName => $errorMessage) {
			$field = $FieldHandler->getField([
				'tableName' => 'jakobus_events',
				'fieldName' => $fieldName
			]);
			$msg .= sprintf('<div class="cmtMessage cmtMessageError"><strong>%s</strong><br>%s</div>', $field['cmt_fieldalias'],  $errorMessage);
		}
	}

	$cmt_save = false;
	$cmt_usermessage = $msg;
}
?>
