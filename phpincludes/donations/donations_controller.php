<?php
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Session;
use Contentomat\Debug;
use Contentomat\CmtPage;
use Jakobus\Donation;
use \Exception;


class DonationsController extends Controller {


	/**
	 * @var int 	ID of the page that will show a success message
	 */
	protected $successPageId = 94;

	/**
	 * @var int 	ID of the page that will show an error message
	 */
	protected $errorPageId = 95;

	/**
	 * @var \Contentomat\CmtPage
	 */
	protected $CmtPage;

	/**
	 * @var Contentomat\SessionHandler
	 */
	private $Session;

	/**
	 * @var string
	 */
	protected $transactionType;


	public function init () {
		$this->Donation = new Donation();
		$this->Donation->setLanguage ($this->pageLang);
		$this->CmtPage = new CmtPage();
		$cmt = Contentomat::getContentomat();
		$this->Session = $cmt->getSession();

		$this->templatesPath = $this->templatesPath . 'donations/';

		$this->transactionType = $this->getvars['transaction_type'];
	}


	/**
	 * Show a donation button
	 */
	public function actionDefault () {

		if (!empty($this->postvars)) {
			try {
				$this->postvars['amount'] = sprintf("%.2f", (float)str_replace(',', '.', $this->postvars['amount']));
				if (!$this->Donation->validate($this->postvars)) {
					throw new Exception("invalid-input");
				}

				$amount = (float)$this->postvars['amount'];
				$paymentMethod = $this->postvars['payment_method'];

				// Save POST data for later (needed after redirect)
				$this->Session->setMultipleSessionVars($this->postvars);

				// Try to pay
				if (!$this->Donation->pay($amount, $paymentMethod)) {
					$this->parser->setParserVar('errorMessage', $this->Donation->getErrorMessage());
					throw new Exception("payment-failed");
				}

				return;
			}
			catch (Exception $e) {
				$this->parser->setParserVar('error', $e->getMessage());
				$this->parser->setMultipleParserVars($this->Donation->getValidationErrors());
			}
		}

		$this->parser->setParserVar('wantsReceipt', $this->Donation->wantsReceipt($this->postvars));
		$this->parser->setMultipleParserVars($this->postvars);
		$this->content = $this->parser->parseTemplate($this->templatesPath . 'form.tpl');
	}


	/**
	 * Redirect from Giropay payment
	 */
	public function actionPaymentRedirect() {
		if ($this->Donation->paymentRedirect($this->transactionType)) {

			// Get POST data from Session
			$data = [
				'amount' => $this->Session->getSessionVar('amount'),
				'payment_method' => $this->Session->getSessionVar('payment_method'),
				'donation_salutation' => $this->Session->getSessionVar('donation_salutation'),
				'donation_firstname' => $this->Session->getSessionVar('donation_firstname'),
				'donation_lastname' => $this->Session->getSessionVar('donation_lastname'),
				'donation_street_address' => $this->Session->getSessionVar('donation_street_address'),
				'donation_zip' => $this->Session->getSessionVar('donation_zip'),
				'donation_city' => $this->Session->getSessionVar('donation_city'),
				'donation_country' => $this->Session->getSessionVar('donation_country')
			];

			// Notify website admin
			$this->Donation->notifyAdmin($data);

			$pageId = $this->successPageId;
		}
		else {
			$pageId = $this->errorPageId;
		}

		// Clean-up and redirect
		$this->Session->deleteAllSessionVars();
		$this->CmtPage->redirectToPage($pageId, $this->pageLang);
	}

	
	/**
	 * Notify from Giropay payment
	 */
	public function actionPaymentNotify() {
		$this->Donation->paymentNotify($this->transactionType);
	}
}


$autoLoad = new PsrAutoloader ();
$autoLoad->addNamespace ('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$ctl = new DonationsController ();
$content = $ctl->work ();
?>
