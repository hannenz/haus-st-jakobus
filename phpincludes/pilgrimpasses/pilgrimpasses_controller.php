<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\CmtPage;
use Contentomat\Debug;
use Jakobus\Pilgrimpass;
use Jakobus\Order;
use Jakobus\CorporateData;
use \Exception;


require_once(PATHTOWEBROOT.'phpincludes/vendor/GiroCheckout_SDK/GiroCheckout_SDK.php');
require_once(PATHTOWEBROOT.'phpincludes/vendor/GiroCheckout_SDK/GiroCheckout_SDK_Notify.php');

class PilgrimpassesController extends Controller {


	protected $successPageId = 84;


	/**
	 * @var Object
	 */
	private $Session;

	/**
	 * @var Contentomat\CmtPage
	 */
	private $CmtPage;


	/**
	 * @var Jakobus\Pilgrimpass
	 */
	protected $Pilgrimpass;

	/**
	 * @var Jakobus\Order
	 */
	protected $Order;

	/**
	 * @var Jaokbus\CorporateData
	 */
	protected $CorporateData;



	public function init () {
		$this->Pilgrimpass = new Pilgrimpass();
		$this->Order = new Order();
		$this->CorporateData = new CorporateData();
		$this->Pilgrimpass->setLanguage($this->pageLang);
		$cmt = Contentomat::getContentomat();
		$this->Session = $cmt->getSession();
		$this->CmtPage = new CmtPage();

		$this->templatesPath = $this->templatesPath . 'pilgrimpasses/';
		include(PATHTOWEBROOT.'giropay_settings.php');
		$this->giropaySettings = $giropaySettings;
	}


	public function initActions($action = '') {
		parent::initActions();


		if (!empty($_REQUEST['action'])) {
			$this->action = $_REQUEST['action'];
			return;
		}

		if ($this->pageId == $this->successPageId) {
			$this->action = 'success';
		}

		if (empty($this->action)) {
			$this->action = 'step1';
		}
	}



	public function actionDefault() {
		$this->changeAction('step1');
	}



	/**
	 * One step back
	 */
	public function actionBack() {
		switch($this->postvars['step']) {
			case '2':
				$newAction = 'step1';
				$postvars = $this->Session->getSessionVar('pilgrimpasses');
				break;
			case '3':
				$newAction = 'step2';
				$postvars = $this->Session->getSessionVar('deliveryAddress');
				break;
			case 'summary':
				$newAction = 'step3';
				$postvars = $this->Session->getSessionVar('paymentMethod');
				break;
			default:
				$newAction = 'step1';
				break;
		}

		$this->postvars = $postvars;
		$this->changeAction($newAction);
	}


	/**
	 * Continue an order
	 *
	 * @return void
	 */
	public function actionContinue() {
		$lastStep = $this->Session->getSessionVar('completedStep');
		switch ($lastStep) {
			case 1:
				$newAction = 'step2';
				break;
			case 2:
				$newAction = 'step3';
				break;
			case 3:
				$newAction = 'summary';
				break;
			default:
				$newAction = 'default';
		}

		$this->changeAction($newAction);
	}

	/**
	 * Enter pilgrimpass data
	 */
	public function actionStep1() {

		$this->Session->deleteSessionVar('completedStep');
		$errors = [];

		if (empty($this->postvars)) {
			$pilgrimpasses = [ [] ];
		}
		else if ($this->postvars['action'] == 'step1') {
			$keys = array_keys($this->postvars);
			$count = $this->postvars['count'];
			$pilgrimpasses = [];

			for ($i = 0; $i < $count; $i++) {

				$pass = [];
				foreach ($keys as $key) {
					if (preg_match('/^pilgrimpass_/', $key)) {
						$pass[$key] = trim($this->postvars[$key][$i]);
					}
				}

				// Validate each set
				foreach ($pass as $field => $value) {
					if (!$this->Pilgrimpass->validateFormField($field, $value)) {
						$pass['error_'.$field] = true;
						$errors[] = $field;
					}
				}
				$pilgrimpasses[] = $pass;
			}

			if (empty($errors)) {
				$this->Session->setSessionVar('pilgrimpasses', $pilgrimpasses);
				$this->Session->saveSessionVars();
				$this->changeAction('step2');
				return;
			}
		}
		else {
			// Coming "back" from step2
			$pilgrimpasses = $this->postvars;
		}

		$this->parser->setParserVar('startDateMin', strftime('%Y-%m-%d', strtotime('+6 days')));
		$this->parser->setParserVar('pilgrimpasses', $pilgrimpasses);
		$this->parser->setParserVar('count', count($pilgrimpasses));
		$this->parser->setParserVar('errors', $errors);
		if (!empty($errors)) {
			$this->parser->setParserVar('saveFailed', true);
		}
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'step1.tpl');
	}



	/**
	 * Enter delivery address
	 */
	public function actionStep2() {

		$this->Session->setSessionVar('completedStep', 1);
		$errors = [];
		if (!empty($this->postvars['action']) && $this->postvars['action'] == 'step2') {
			foreach ($this->postvars as $field => $value) {
				if (preg_match('/^order_delivery_address_/', $field)) {
					if (!$this->Order->validateFormField($field, $value)) {
						$this->postvars['error_'.$field] = true;
						$errors[] = $field;
					}
				}
			}

			if (!empty($errors)) {
				$this->parser->setParserVar('saveFailed', true);
			}
			else {
				$deliveryAddress = [
					'order_delivery_address_salutation' => $this->postvars['order_delivery_address_salutation'],
					'order_delivery_address_firstname' => $this->postvars['order_delivery_address_firstname'],
					'order_delivery_address_lastname' => $this->postvars['order_delivery_address_lastname'],
					'order_delivery_address_street' => $this->postvars['order_delivery_address_street'],
					'order_delivery_address_zip' => $this->postvars['order_delivery_address_zip'],
					'order_delivery_address_city' => $this->postvars['order_delivery_address_city'],
					'order_delivery_address_country' => $this->postvars['order_delivery_address_country'],
					'order_delivery_address_email' => $this->postvars['order_delivery_address_email']
				];
				$this->Session->setSessionVar('deliveryAddress', $deliveryAddress);
				$this->Session->saveSessionVars();
				$this->changeAction('step3');
				return;
			}
		}

		$this->parser->setMultipleParserVars($this->postvars);
		$this->parser->setParserVar('errors', $errors);

		// Get delivery address from Session (if coming back to the form)
		$deliveryAddress = $this->Session->getSessionVar('deliveryAddress');

		// Set the first pilgrim pass as default delivery address, if no address
		// in session and coming from step 1
		if ($this->postvars['step'] == 1 && empty($deliveryAddress)) {
			$deliveryAddress = [
				'order_delivery_address_salutation' => $this->postvars['pilgrimpass_salutation'][0],
				'order_delivery_address_firstname' => $this->postvars['pilgrimpass_firstname'][0],
				'order_delivery_address_lastname' => $this->postvars['pilgrimpass_lastname'][0],
				'order_delivery_address_street' => $this->postvars['pilgrimpass_street_address'][0],
				'order_delivery_address_zip' => $this->postvars['pilgrimpass_zip'][0],
				'order_delivery_address_city' => $this->postvars['pilgrimpass_city'][0],
				'order_delivery_address_country' => $this->postvars['pilgrimpass_country'][0],
				'order_delivery_address_email' => $this->postvars['pilgrimpass_email'][0]
			];
		}

		$this->parser->setMultipleParserVars($deliveryAddress);

		$this->content = $this->parser->parseTemplate($this->templatesPath . 'step2.tpl');
	}



	/**
	 * Enter payment method
	 */
	public function actionStep3() {

		$errors = [];
		$this->Session->setSessionVar('completedStep', 2);

		if (!empty($this->postvars['action'] && $this->postvars['action'] == 'step3')) {

			if ($this->postvars['order_amount'] == 'custom') {
				$this->postvars['order_amount'] = (int)trim($this->postvars['order_amount_custom']);
			}
			if (empty($this->postvars['order_amount'])) {
				$this->postvars['order_amount'] = 0;
			}
			// unset ($this->postvars['order_amount_custom']);

			foreach ($this->postvars as $field => $value) {
				if (preg_match('/^pilgrimpass_/', $field)) {
					if (!$this->Pilgrimpass->validateFormField($field, $value)) {
						$this->postvars['error_'.$field] = true;
						$errors[] = $field;
					}
				}
			}

			if (!empty($errors)) {
				$this->parser->setParserVar('saveFailed', true);
			}
			else {
				$paymentMethod = [
					'order_payment_method' => $this->postvars['order_payment_method'],
					'order_express' => $this->postvars['order_express'],
					'order_amount' => $this->postvars['order_amount'],
					'order_amount_custom' => $this->postvars['order_amount_custom'],
					'order_message' => $this->postvars['order_message']
				];
				$this->Session->setSessionVar('paymentMethod', $paymentMethod);
				$this->Session->saveSessionVars();
				$this->changeAction('summary');
				return;
			}
		}

		$pilgrimpasses = $this->Session->getSessionVar('pilgrimpasses');
		$pilgrimpassesCount = count($pilgrimpasses);
		$amount1 = $pilgrimpassesCount * 5;
		$amount2 = $pilgrimpassesCount * 10;
		$amount3 = $pilgrimpassesCount * 20;
		$this->parser->setMultipleParserVars([
			'pilgrimpassesCount' => $pilgrimpassesCount,
			'amount1' => $amount1,
			'amount2' => $amount2,
			'amount3' => $amount3,
			'errors' => $errors
		]);
		$this->parser->setMultipleParserVars($this->postvars);

		$this->content = $this->parser->parseTemplate($this->templatesPath . 'step3.tpl');
	}



	/**
	 * Display summary and save / complete order
	 */
	public function actionSummary() {
		$this->Session->setSessionVar('completedStep', 3);

		$this->parser->setParserVar('pilgrimpasses', $this->Session->getSessionVar('pilgrimpasses'));
		$this->parser->setMultipleParserVars($this->Session->getSessionVar('deliveryAddress'));
		$this->parser->setMultipleParserVars($this->Session->getSessionVar('paymentMethod'));

		$this->content = $this->parser->parseTemplate($this->templatesPath . 'summary.tpl');
	}



	public function actionComplete() {

		$pilgrimpasses = $this->Session->getSessionVar('pilgrimpasses');
		$deliveryAddress = $this->Session->getSessionVar('deliveryAddress');
		$paymentMethod = $this->Session->getSessionVar('paymentMethod');

		// TODO: Validation and error handling!!!
		$data = array_merge($deliveryAddress, $paymentMethod);
		$data['order_date'] = strftime('%Y-%m-%d %H:%M:%S');
		$data['order_shipping_status'] = 'open';
		$orderId = $this->Order->save($data);

		if (empty($this->postvars['data-privacy-statement-accepted'])) {
			$this->parser->setParserVar('data-privacy-statement-not-accepted', true);
			$this->changeAction('summary');
		}

		foreach ($pilgrimpasses as $pilgrimpass) {
			$pilgrimpass['pilgrimpass_order_id'] = $orderId;
			$errors = $this->Pilgrimpass->validate($pilgrimpass);
			if (!empty($errors)) {
				var_dump($errors);
				die ("oh no!");
			}
			$pilgrimpass['pilgrimpass_date'] = strftime('%Y-%m-%d %H:%M:%S');
			$pilgrimpass['pilgrimpass_pass_nr'] = $this->Pilgrimpass->getNextPassNr();
			$check = $this->Pilgrimpass->save(array_merge($pilgrimpass, $deliveryAddress, $paymentMethod));
			if (!$check) {
				$this->parser->setParserVar('saveFailed', true);
				$this->content = $this->parser->parseTemplate($this->templatesPath . 'summary.tpl');
				return;
			}
		}

		$data = array_merge($deliveryAddress, $paymentMethod);
		$data['pilgrimpasses'] = $pilgrimpasses;

		$this->Pilgrimpass->notifyUser($data);
		$this->Pilgrimpass->notifyAdmin($data);

		// Prevent double submission
		$loc = sprintf('Location: %s%s?action=success&orderId=%u',
			$this->CmtPage->makePageFilePath($this->successPageId),
			$this->CmtPage->makePageFileName($this->successPageId),
			$orderId
		);
		header($loc);
		exit;
	}


	public function actionSuccess() {
		$this->clearCart();

		if (empty($this->getvars['orderId'])) {
			$this->CmtPage->redirectToPage(24, $this->pageLang);
			return;
		}
		$id = (int)$this->getvars['orderId'];
		$data = $this->Order->findById($id);
		if (empty($data)) {
			$this->CmtPage->redirectToPage(24, $this->pageLang);
			return;
		}
		$corporateData = $this->CorporateData->getData();
		$this->parser->setMultipleParserVars($corporateData);
		$this->parser->setMultipleParserVars($data);
		$this->parser->setParserVar('orderId', $id);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'success.tpl');

	}


	/**
	 * Abort an order, clear the cart
	 */
	public function actionAbort() {
		$this->clearCart();
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'aborted.tpl');
	}


	/**
	 * Clear the cart
	 */
	protected function clearCart() {
		$this->Session->deleteSessionVar('pilgrimpasses');
		$this->Session->deleteSessionVar('deliveryAddress');
		$this->Session->deleteSessionVar('paymentMethod');
		$this->Session->deleteSessionVar('completedStep');
	}



	public function afterSave ($success, $data, $options) {
		return $success;
	}



	/**
	 * Handle online payment 
	 * via giropay, paypal or sofort
	 *
	 * @access public
	 */
	public function actionPay() {

		$orderId = $_REQUEST['order_id'];
		$transactionType = $_REQUEST['transaction_type'];
		// if ($transactionType != 'giropay' && $transactionType != 'paypal' && $transactionType != 'sofortuw') {
		// 	throw new \Exception("Invalid transaction type: " . $transactionType);
		// }

		if (empty($this->giropaySettings[$transactionType])) {
			throw new \Exception("Missing or invalid transaction type: " . $transactionType);
		}

		try {
			$amount = (int)((float)$_REQUEST['amount'] * 100);
			$request = new \GiroCheckout_SDK_Request($transactionType . 'Transaction');
			$request->setSecret($this->giropaySettings[$transactionType]['secret']);
			$request->addParam('merchantId', $this->giropaySettings[$transactionType]['merchantId']);
			$request->addParam('projectId', $this->giropaySettings[$transactionType]['projectId']);
			$request->addParam('merchantTxId', 'Pilgerpass Haus St. Jakobus');
			$request->addParam('amount', $amount);
			$request->addParam('currency', 'EUR');
			$request->addParam('purpose', 'Pilgerpass Bestellung ID ' . $orderId);
			$request->addParam('urlRedirect', 
				sprintf('https://%s/%s%s?action=paymentRedirect&orderId=%u&transaction_type=%s',
					$_SERVER['SERVER_NAME'],
					$this->CmtPage->makePageFilePath($this->successPageId),
					$this->CmtPage->makePageFileName($this->successPageId),
					$orderId,
					$transactionType
				)
			);
			$request->addParam('urlNotify', 
				sprintf('https://%s/%s%s?action=paymentNotify&orderId=%u&transaction_type=%s',
					$_SERVER['SERVER_NAME'],
					$this->CmtPage->makePageFilePath($this->successPageId),
					$this->CmtPage->makePageFileName($this->successPageId),
					$orderId,
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
				die ("Transaction failed: " . $mssg);
			}
		}
		catch (Exception $e) {
			die($e->getMessage());
			$this->parser->setParserVar('error', $e->getMessage());
		}
		$this->parser->parseTemplate($this->templatesPath . 'success.tpl');
	}



	/**
	 * Payment Redirect Callback
	 *
	 * @return void
	 */
	public function actionPaymentRedirect() {

		$transactionType = $this->getvars['transaction_type'];
		if (empty($this->giropaySettings[$transactionType])) {
			throw new Exception("Missing or invalid transaction type: " . $transactionType);
		}

		try {

			$notify = new \GiroCheckout_SDK_Notify($transactionType . 'Transaction');
			$notify->setSecret($this->giropaySettings[$transactionType]['secret']);
			$notify->parseNotification($_GET);

			if ($notify->paymentSuccessful()) {
				$orderId = $_REQUEST['orderId'];
				$this->Order->setPaymentStatus($orderId, PAYMENT_STATUS_PAYED);
				$this->parser->setMultipleParserVars([
					'gcReference' => $notify->getResponseParam('gcReference'),
					'gcMerchantTxId' => $notify->getResponseParam('gcMerchantTxId'),
					'gcBackendTxId' => $notify->getResponseParam('gcBackendTxId'),
					'gcAmount' => $notify->getResponseParam('gcAmount'),
					'gcCurrency' => $notify->getResponseParam('gcCurrency'),
					'gcResultPayment' => $notify->getResponseParam('gcResultPayment')
				]);

				return $this->CmtPage->redirectToPage(87, $this->pageLang);
			}
			else {
				// Payment failed
				$this->parser->setParserVar('payment_error_message', 'Die Zahlung konnte nicht durchgeführt werden oder der Bezahlvorgang wurde abgebrochen. Bitte versuchen Sie es erneut oder setzen Sie sich mit uns in Verbindung');
				return $this->changeAction('success');
			}
		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}
	}


	/**
	 * Payment Notify Callback
	 *
	 * @return void
	 */
	public function actionPaymentNotify() {
		$transactionType = $this->getvars['transaction_type'];
		if (empty($this->giropaySettings[$transactionType])) {
			throw new Exception("Missing or invalid transaction type: " . $transactionType);
		}

		$orderId = $this->getvars['order_id'];

		try {
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


$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$autoLoad->addNamespace('Contentomat', INCLUDEPATHTOADMIN . 'classes');
$ctl = new PilgrimpassesController();
$content = $ctl->work();
?>
