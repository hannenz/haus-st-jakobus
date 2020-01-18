<?php
namespace Jakobus;

use Contentomat\Mail;
use Contentomat\Parser;
use Contentomat\Logger;
use Contentomat\ApplicationHandler;
use Jakobus\CorporateData;



/**
 * Send notification mails to users and website admin
 *
 * @class Notification
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 */
class Notification {

	protected $Mail;
	protected $Parser;
	protected $ApplicationHandler;
	protected $templatesPath;
	protected $CorporateData;

	protected $PageMailerAppId = 152;
	

	protected $adminNotificationRecipient = 'pilgerpass@haus-st-jakobus.de';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->ApplicationHandler = new ApplicationHandler();
		$this->CorporateData = new CorporateData();
		$pageMailerSettings = $this->ApplicationHandler->getApplicationSettings($this->PageMailerAppId);

		$this->Mail = new Mail([
			'senderName' => $pageMailerSettings['senderName'],
			'senderMail' => $pageMailerSettings['senderMail'],
			'transport' => 'smtp',
			'smtpHost' => $pageMailerSettings['smtpHost'],
			'smtpUsername' => $pageMailerSettings['smtpUsername'],
			'smtpPassword' => $pageMailerSettings['smtpPassword'],
			'smtpPort' => $pageMailerSettings['smtpPort'],
		]);
		$this->Parser = new Parser();
	}


	/**
	 * Send a notification mail
	 *
	 * @param mixed 	String|Array of recipients
	 * @param string 	Subject
	 * @param string 	template to use
	 * @param Array 	Data
	 * @return boolean 	Success
	 */
	public function notify($recipient, $subject, $template, $data) {

		$this->Parser->setParserVar('complimentary_close', $this->CorporateData->getField('complimentary_close'));

		$this->Parser->setMultipleParserVars($data);
		$textContent = $this->Parser->parseTemplate($this->templatesPath . $template . '.txt.tpl');
		$this->Parser->setParserVar('mailContent', $textContent);
		$text = $this->Parser->parseTemplate(PATHTOWEBROOT . "templates/email.txt.tpl");
		$htmlContent = $this->Parser->parseTemplate($this->templatesPath . $template . '.html.tpl');
		$this->Parser->setParserVar('mailContent', $htmlContent);
		$html = $this->Parser->parseTemplate(PATHTOWEBROOT . "templates/email.html.tpl");

		$success = $this->Mail->send([
			'recipient' => $recipient,
			'subject' => $subject,
			'text' => $text,
			'html' => $html
		]);

		Logger::log(sprintf("Sending mail to <%s> [%s] Template: %s [%s]",
			$recipient,
			$subject,
			$this->templatesPath . $template,
			$success ? "OK" : "FAILED"
		));

		return $success;
	}


	/**
	 * Notify website administrator
	 * 
	 * @param string 	Subject
	 * @param string 	template to use
	 * @param Array 	Data
	 * @return boolean 	Success
	 */
	public function notifyAdmin($subject, $template, $data) {
		return $this->notify($this->adminNotificationRecipient, $subject, $template, $data);
	}
	

	/**
	 * Getter for templatesPath
	 *
	 * @return string
	 */
	public function getTemplatesPath() {
	    return $this->templatesPath;
	}
	
	/**
	 * Setter for templatesPath
	 *
	 * @param string $templatesPath
	 */
	public function setTemplatesPath($templatesPath) {
	    $this->templatesPath = $templatesPath;
	}

	/**
	 * Getter for adminNotificationRecipient
	 *
	 * @return string
	 */
	public function getAdminNotificationRecipient() {
	    return $this->adminNotificationRecipient;
	}
	
	/**
	 * Setter for adminNotificationRecipient
	 *
	 * @param string $adminNotificationRecipient
	 */
	public function setAdminNotificationRecipient($adminNotificationRecipient) {
	    $this->adminNotificationRecipient = $adminNotificationRecipient;
	}
}
?>
