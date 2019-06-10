<?php
namespace Jakobus;

use Contentomat\CmtPage;
use Jakobus\Model;
use Jakobus\Notification;
use \Exception;

require_once(PATHTOWEBROOT.'phpincludes/vendor/GiroCheckout_SDK/GiroCheckout_SDK.php');
require_once(PATHTOWEBROOT.'phpincludes/vendor/GiroCheckout_SDK/GiroCheckout_SDK_Notify.php');

/**
 * Handle donations
 *
 * @class Donation
 * @package jakobus
 * @author Johannes Braun <johannes.braun@agentur-halma.de>
 */
class Donation extends Model {

	/**
	 * @var string
	 */
	protected $adminNotificationRecipient = 'jbhannenz@gmail.com';

	/**
	 * @var int
	 */
	protected $successPageId = 63;

	/**
	 * @var \Jakobus\Notiifcation
	 */
	protected $Notification;

	/**
	 * @var \Contentomat\CmtPage
	 */
	protected $CmtPage;

	/**
	 * @var string
	 */
	protected $errorMessage = '';


	public function init() {

		$this->Notification = new Notification();
		$this->Notification->setTemplatesPath(PATHTOWEBROOT . "templates/donations/");
		$this->CmtPage = new CmtPage();

		$this->setValidationRules([
			'paymentMethod' => '/paypal|giropay/'
		]);

		include(PATHTOWEBROOT.'giropay_settings.php');
		$this->giropaySettings = $giropaySettings;
	}


	/**
	 * Validate user input (custom)
	 *
	 * @param array 		the user input (POST)
	 * @return boolean 		Validation success
	 */
	public function validate($data) {

		$this->validationErrors = [];

		$amount = (float)$data['amount'];
		if ($amount <= 0) {
			$this->validationErrors['error_amount'] = true;
		}

		// Personal data should be either all blank or all set:
		if ($this->wantsReceipt($data)) {
			if ($amount < 50) {
				$this->validationErrors['error_donation_too_small_for_receipt'] = true;
			}
			if (empty($data['donation_firstname'])) {
				$this->validationErrors['error_donation_firstname'] = true;
			}
			if (empty($data['donation_lastname'])) {
				$this->validationErrors['error_donation_lastname'] = true;
			}
			if (empty($data['donation_street_address'])) {
				$this->validationErrors['error_donation_street_address'] = true;
			}
			if (!preg_match('/^[0-9]{5}$/', $data['donation_zip'])) {
				$this->validationErrors['error_donation_zip'] = true;
			}
			if (empty($data['donation_city'])) {
				$this->validationErrors['error_donation_city'] = true;
			}
			if (empty($data['donation_country'])) {
				$this->validationErrors['error_donation_country'] = true;
			}
		}

		return empty($this->validationErrors);
	}

	/**
	 * Handle payment
	 *
	 * @param int 			Amount (in EUR)
	 * @param string 		Payment method: Either "paypal" or "giropay"
	 * @return void 
	 * @throws Exception
	 */
	public function pay($amount, $transactionType) {
		if (empty($this->giropaySettings[$transactionType])) {
			throw new \Exception("Missing or invalid transaction type: " . $transactionType);
		}
		try {
			$amount = $amount * 100;
			$request = new \GiroCheckout_SDK_Request($transactionType . 'Transaction');
			$request->setSecret($this->giropaySettings[$transactionType]['secret']);
			$request->addParam('merchantId', $this->giropaySettings[$transactionType]['merchantId']);
			$request->addParam('projectId', $this->giropaySettings[$transactionType]['projectId']);
			$request->addParam('merchantTxId', 'Cursillo-Haus St Jakobus');
			$request->addParam('amount', $amount);
			$request->addParam('currency', 'EUR');
			$request->addParam('purpose', 'Spende Cursillo St Jakobus');
			$request->addParam('urlRedirect', 
				sprintf('https://%s/%s%s?action=paymentRedirect&transaction_type=%s',
					$_SERVER['SERVER_NAME'],
					$this->CmtPage->makePageFilePath($this->successPageId),
					$this->CmtPage->makePageFileName($this->successPageId),
					$transactionType
				)
			);
			$request->addParam('urlNotify', 
				sprintf('https://%s/%s%s?action=paymentNotify&transaction_type=%s',
					$_SERVER['SERVER_NAME'],
					$this->CmtPage->makePageFilePath($this->successPageId),
					$this->CmtPage->makePageFileName($this->successPageId),
					$transactionType
			));
			$request->submit();

			if ($request->requestHasSucceeded()) {
				$request->getResponseParam('rc');
				$request->getResponseParam('mssg');
				$request->getResponseParam('reference');
				$request->getResponseParam('redirect');
				$request->redirectCustomerToPaymentProvider();
			}
			else {
				$rc = $request->getResponseParam('rc');
				$request->getResponseParam('msg');
				$mssg = $request->getResponseMessage($rc, 'DE');
				throw new Exception($mssg);
			}
		}
		catch (Exception $e) {
			$this->errorMessage = $e->getMessage();
			return false;
		}
		return true;
	}


	/**
	 * Send a notification to website admin
	 *
	 * @throws Exception
	 * @return void
	 */
	public function notifyAdmin($data) {

		$data['donationDateTimeFmt'] = strftime('%d.%m.%Y %H:%M:%S');
		$data['amountFmt'] = sprintf('%.2f', (float)$data['amount']);

		return $this->Notification->notify(
			$this->adminNotificationRecipient,
			'Eine Spende ist eingegangen',
			'notify_admin',
			$data
		);
	}

	
	public function wantsReceipt($data) {
		return (
			!empty($data['donation_firstname']) ||
			!empty($data['donation_lastname']) ||
			!empty($data['donation_street_address']) ||
			!empty($data['donation_zip']) ||
			!empty($data['donation_city']) ||
			!empty($data['donation_country'])
		);
	}


	/**
	 * Getter for errorMessage
	 *
	 * @return string
	 */
	public function getErrorMessage() {
	    return $this->errorMessage;
	}


	/**
	 * Handle Giropay Redirect
	 *
	 * @return void
	 */
	public function paymentRedirect($transactionType) {
		try {
			if (empty($this->giropaySettings[$transactionType])) {
				throw new Exception("Missing or invalid transaction type: " . $transactionType);
			}

			$notify = new \GiroCheckout_SDK_Notify($transactionType . 'Transaction');
			$notify->setSecret($this->giropaySettings[$transactionType]['secret']);
			$notify->parseNotification($_GET);

			if (!$notify->paymentSuccessful()) {
				throw new Exception("Zahlung konnte nicht durchgeführt werden");
			}
			return true;
		}
		catch (\Exception $e) {
			$this->errorMessage = $e->getMessage();
			return false;
		}
	}


	/**
	 * Handle Giropay Notify
	 *
	 * @return void
	 */
	public function paymentNotify($transactionType) {
		try {
			if (empty($this->giropaySettings[$transactionType])) {
				throw new Exception("Missing or invalid transaction type: " . $transactionType);
			}

			$notify = new \GiroCheckout_SDK_Notify($transactionType . 'Transaction');
			$notify->setSecret($this->giropaySettings[$transactionType]['secret']);
			$notify->parseNotification($_GET);

			if ($notify->paymentSuccessful()) {
				echo $notify->getResponseParam('gcReference') . "<br>";
				echo $notify->getResponseParam('gcMerchantTxId') . "<br>";
				echo $notify->getResponseParam('gcBackendTxId') . "<br>";
				echo $notify->getResponseParam('gcAmount') . "<br>";
				echo $notify->getResponseParam('gcCurrency') . "<br>";
				echo $notify->getResponseParam('gcResultPayment') . "<br>";

				if ($notify->avsSuccessful()) {
					echo $notify->getResponseParam('gcResultAVS');
				}

				$notify->sendOkStatus();
				$notify->setNotifyResponseParam('Result', 'OK');
				$notify->setNotifyResponseParam('ErrorMessage', '');
				$notify->setNotifyResponseParam('MailSent', '0');
				$notify->setNotifyResponseParam('OrderId', $orderId);
				$notify->setNotifyResponseParam('CustomerId', '');
				echo $notify->getNotifyResponseStringJson() . "<br>";
				exit;
			}
			else {
				$notify->getResponseParam('gcReference');
				$notify->getResponseParam('gcMerchantTxId');
				$notify->getResponseParam('gcBackendTxId');
				$notify->getResponseParam('gcResultPayment');

				$notify->sendOkStatus();
				$notify->getResponseMessage($notify->getResponseParam('gcResultPayment'), 'DE');
				$notify->sendOkStatus();
				$notify->setNotifyResponseParam('Result', 'OK');
				$notify->setNotifyResponseParam('ErrorMessage', '');
				$notify->setNotifyResponseParam('MailSent', '0');
				$notify->setNotifyResponseParam('OrderId', $orderId);
				$notify->setNotifyResponseParam('CustomerId', '');
				echo $notify->getNotifyResponseStringJson();
				exit;
			}
		}
		catch (\Exception $e) {
			$notify->sendBadRequestStatus();
			$notify->setNotifyResponseParam('Result', 'ERROR');
			$notify->setNotifyResponseParam('ErrorMessage', $e->getMessage());
			$notify->setNotifyResponseParam('MailSent', '0');
			$notify->setNotifyResponseParam('OrderId', $orderId);
			$notify->setNotifyResponseParam('CustomerId', '');
			echo $notify->getNotifyResponseStringJson();
			exit;
		}
	}
}
?>
