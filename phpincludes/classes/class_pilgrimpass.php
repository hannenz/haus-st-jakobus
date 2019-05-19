<?php
namespace Jakobus;

use Contentomat\DBCex;
use Contentomat\FileHandler;
use Contentomat\FieldHandler;
use Jakobus\Notification;
use \Exception;



class Pilgrimpass extends Model {


	// protected $adminNotificationRecipient = 'pilgerpass_neu@haus-st-jakobus.de';

	/**
	 * @var \Contentomat\FileHandlex
	 */
	protected $FileHandler;

	/**
	 * @var \Contentomat\FileHandlex
	 */
	protected $FieldHandler;

	/**
	 * @var \Jakobus\Notification
	 */
	protected $Notification;

	public function init () {
		parent::init ();

		$this->FileHandler = new FileHandler();
		$this->FieldHandler = new FieldHandler();
		$this->Notification = new Notification();
		$this->Notification->setTemplatesPath(PATHTOWEBROOT . 'templates/pilgrimpasses/notifications/');

		$this->setTableName('jakobus_pilgrimpasses');
		$this->setValidationRules([
			'pilgrimpass_firstname' => [
				'not-empty' => '/^\S+$/',
			],
			'pilgrimpass_lastname' => [
				'not-empty' => '/^\S+$/',
			],
			'pilgrimpass_birthday' => '/^\d{4}-\d{2}-\d{2}$/',
			'pilgrimpass_street_address' => '/^.+$/',
			'pilgrimpass_country' => '/^.+$/',
			'pilgrimpass_zip' => '/^\d{5}$/',
			'pilgrimpass_city' => '/^.+$/',
			'pilgrimpass_email' => '/^.+@.+\..{2,3}$/',
			'pilgrimpass_idnr' => '/^.+$/',
			'pilgrimpass_route' => '/^.+$/',
			'pilgrimpass_start_date' => 'validateStartDate',
			'pilgrimpass_start_location' => '/^.+$/',
			'pilgrimpass_motivation' => '/^.+$/',
			'pilgrimpass_transportation' => '/^.+$/',
			'pilgrimpass_payment_method' => '/^.+$/',
			'pilgrimpass_amount' => '/^[0-9\,\.]+$/',
			'pilgrimpass_delivery_address_firstname' => '/^.+$/',
			'pilgrimpass_delivery_address_lastname' => '/^.+$/',
			'pilgrimpass_delivery_address_street' => '/^.+$/',
			'pilgrimpass_zip' => '/^\d{5}$/',
			'pilgrimpass_delivery_address_city' => '/^.+$/',
			'pilgrimpass_delivery_address_country' => '/^.+$/',
			'pilgrimpass_delivery_address_email' => '/^.+@.+\..{2,3}$/',
		]);
	}


	public function notifyUser($data) {
		$data['passes_count'] = count($data['pilgrimpasses']);
		$recipient = ($data['order_delivery_address_email']);

		return $this->Notification->notify($recipient, "[Haus St. Jakobus] Eingangsbestätigung", "notify_user", $data);
	}

	public function notifyAdmin($data) {
		$this->Parser->setMultipleParserVars($data);
		$data['passes_count'] = count($data['pilgrimpasses']);
		return $this->Notification->notifyAdmin("Antrag Pilgerausweis", "notify_admin", $data);
	}

	/**
	 * The start date must be at least 5 days in the future
	 *
	 * @param string 		The date string to validate
	 * @return boolean
	 */
	protected function validateStartDate($value) {

		$startDateTimestamp = strtotime($value);
		$futureDateTimestamp = strtotime('+5 days');

		return ($startDateTimestamp >= $futureDateTimestamp);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 */
	public function getNextPassNr() {

		$query = sprintf("SELECT pilgrimpass_pass_nr FROM %s ORDER BY pilgrimpass_pass_nr DESC LIMIT 1", $this->getTableName());
		if ($this->db->query($query) != 0) {
			throw new Exception("An internal error occured while generating the pilgrimpass\' serial number");
		}

		$result = $this->db->get();
		$nr = (int)$result['pilgrimpass_pass_nr'];
		if ($nr == null) {
			$nr = 0;
		}
		return (int)$result['pilgrimpass_pass_nr'] + 1;
	}



	/**
	 * undocumented function
	 *
	 * @access public
	 * @param string 	begin (YYYY-DD-MM)
	 * @param string 	end (YYYY-DD-MM)
	 * @return Array
	 */
	public function getInRange($begin, $end) {
		$query = sprintf("SELECT * FROM %s WHERE pilgrimpass_date BETWEEN '%s' AND  '%s' ORDER BY pilgrimpass_date ASC",
			$this->tableName,
			$begin,
			$end
		);
		if ($this->db->query($query) != 0) {
			throw new Exception("Query failed: " . $query);
		}

		$passes = $this->db->getAll();

		return $passes;
	}
	


	/*
	 * For a field of type SELECT, get the corresponding alias for 
	 * a given value.
	 * Returns an empty String ('') if either the value or alias can not be
	 * determined
	 *
	 * @access protected
	 * @pararm string
	 * @param string
	 * @return string
	 * @throws Exception
	 */
	protected function getOptionAlias($fieldName, $value) {
		$fieldInfo = $this->FieldHandler->getField([
			'tableName' => $this->tableName,
			'fieldName' => $fieldName
		]);

		if (!$fieldInfo || $fieldInfo['cmt_fieldtype'] != 'select') {
			throw new Exception("Illegal field type");
		}

		$data = unserialize($fieldInfo['cmt_options']);
		// Don't use `explode("\n")` it does not work (presumably because of
		// weird / mixed line endings \n / \r etc/
		$values = preg_split("/\r\n|\n|\r/", $data['values']);
		$aliases = preg_split("/\r\n|\n|\r/", $data['aliases']);

		$key = array_search($value, $values);
		if ($key === false) {
			return '';
		}

		return (isset($aliases[$key]) ? $aliases[$key] : '');
	}



	/**
	 * Export pilgrimpasses of a given range to CSV
	 *
	 * @access public
	 * @throws Exception
	 * @param string 	begin (YYYY-DD-MM)
	 * @param string 	end (YYYY-DD-MM)
	 * @return void
	 */
	public function exportCsv($begin, $end) {

		$passes = $this->getInRange($begin, $end);
		$lines = ["ID,Lfd.Nr,Datum,Anrede,Vorname,Nachname,Anschrift,Postleitzahl,Stadt,Land,Telefon,E-Mail,Route,Start-Datum,Start-Ort,Motivation,Transportmittel,Bezahlart,Express,Betrag,Status,Versand-Datum\n"];
		foreach ($passes as $pass) {
				$lines[] = join(',', [
					sprintf('"%s"', $pass['id']),
					sprintf('"%s"', $pass['pilgrimpass_pass_nr']),
					sprintf('"%s"', strftime('%d.%m.%Y', strtotime($pass['pilgrimpass_date']))),
					sprintf('"%s"', $this->getOptionAlias('pilgrimpass_salutation', $pass['pilgrimpass_salutation'])),
					sprintf('"%s"', $pass['pilgrimpass_firstname']),
					sprintf('"%s"', $pass['pilgrimpass_lastname']),
					sprintf('"%s"', $pass['pilgrimpass_street_address']),
					sprintf('"%s"', $pass['pilgrimpass_zip']),
					sprintf('"%s"', $pass['pilgrimpass_city']),
					sprintf('"%s"', $pass['pilgrimpass_country']),
					sprintf('"%s"', $pass['pilgrimpass_phone']),
					sprintf('"%s"', $pass['pilgrimpass_email']),
					sprintf('"%s"', $this->getOptionAlias('pilgrimpass_route', $pass['pilgrimpass_route'])),
					sprintf('"%s"', strftime('%d.%m.%Y', strtotime($pass['pilgrimpass_start_date']))),
					sprintf('"%s"', $pass['pilgrimpass_start_location']),
					sprintf('"%s"', $this->getOptionAlias('pilgrimpass_motivation', $pass['pilgrimpass_motivation'])),
					sprintf('"%s"', $this->getOptionAlias('pilgrimpass_transportation', $pass['pilgrimpass_transportation'])),
					sprintf('"%s"', $this->getOptionAlias('pilgrimpass_payment_method', $pass['pilgrimpass_payment_method'])),
					sprintf('"%s"', $pass['pilgrimpass_express']),
					sprintf('"%s"', $pass['pilgrimpass_amount']),
					sprintf('"%s"', $this->getOptionAlias('pilgrimpass_status', $pass['pilgrimpass_status'])),
					sprintf('"%s"', strftime('%d.%m.%Y', strtotime($pass['pilgrimpass_shipping_date'])))
				]
			) . "\n";
		}


		$tmpFile = tempnam(PATHTOTMP, 'pp');
		$handle = fopen($tmpFile, 'w');
		foreach ($lines as $line) {
			fwrite($handle, $line);
		}
		fclose($handle);

		$error = $this->FileHandler->handleDownload([
			'downloadFile' => $tmpFile,
			'downloadFileAlias' => sprintf('haus_st_jakobus_Pilgerausweise_von_%s_bis_%s_stand_%s.csv', $begin, $end, strftime('%Y-%m-%d-%H%M')),
			'deleteFile' => true
		]);

		if (!empty($error)) {
			throw new Exception("Serving file for download failed: %s", $error);
		}
	}
}
?>

