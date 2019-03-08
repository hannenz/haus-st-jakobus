<?php
namespace Jakobus;

use Jakobus\Pilgrimpass;
use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Logger;
use Contentomat\FieldHandler;
use Contentomat\DBCex;



$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');

$cmt = Contentomat::getContentomat();
$Pilgrimpass = new Pilgrimpass();
$FieldHandler = new FieldHandler();



try {

	Logger::log('Executing pilgrimpass_before_save.php');
	$validationErrors = $Pilgrimpass->validate($cmtTableDataRaw);

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

		throw new Exception($mssg);
	}

	// Laufende Nummer

	/**
	 * database field: timestamp, must be set to current date on save
	 * database field nr: Must be incremented on each save and reset
	 * 		on year change
	 */

	$currentYear = (int)date('Y');

	$nrFieldName = 'pilgrimpass_pass_nr';
	$dateFieldName = 'pilgrimpass_date';
	$db = new DBCex();
	$query = sprintf("SELECT %s, %s FROM %s ORDER BY %s DESC LIMIT 1", $nrFieldName, $dateFieldName, $Pilgrimpass->getTabeName, $nrFieldName);
	if ($db->query($query) != 0) {
		throw new Exception(sprintf("Query failed: %s", $query));
	}
	else {
		$result = $db->get();
		$lastPassNr = (int)$result[$nrFieldName];
		$lastPassYear = (int)date('Y', strtotime($result[$dateFieldName]));
		if ($lastPassYear == $currentYear) {
			$passNr++;
		}
		else {
			$passNr = 1;
		}

		$cmtTableData[$nrFieldName] = $passNr;
	}
}
catch (Exception $e) {
	Logger::error($e->getMessage());
	$cmt_save = false;
	$cmt_usermessage = $e->getMessage();
}

?>

