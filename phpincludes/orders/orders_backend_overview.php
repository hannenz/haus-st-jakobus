<?php
/**
 * Handle backend functions related to orders/pilgrimpasses
 *
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 */
namespace Jakobus;

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', true);

use Contentomat\PsrAutoloader;
use Contentomat\Parser;
use Contentomat\ApplicationController;
use Jakobus\Order;

class OrdersBackendController extends ApplicationController {


	/**
	 * @var \Jakobus\Order
	 */
	protected $Order;


	public function init() {
		$this->Order = new Order();
		$this->templatesPath = PATHTOWEBROOT . 'templates/orders/';
		$this->initActions($this->action);
	}


	/**
	 * Render the overview's frame (add css link tag)
	 *
	 * @return void
	 * @access public
	 */
	public function actionDefault() {
		$template = $this->templatesPath . 'service_default_frame.tpl';
		$this->content .= $this->parser->parseTemplate($template);
	}


	/**
	 * Toggle an order's shipping status
	 *
	 * @return void
	 * @access public
	 */
	public function actionOrderToggleShipped() {

		$id = $this->getvars['id'];
		$order = $this->Order->findById($id);

		if (!empty($order)) {
			if ($order['order_shipping_status'] == 'shipped') {
				$order['order_shipping_status'] = 'open';
				$order['order_shipping_date'] = '';
			}
			else {
				$order['order_shipping_status'] = 'shipped';
				$order['order_shipping_date'] = strftime('%F %T');
			}
			$this->Order->save($order);
		}

		$this->changeAction('default');
	}
}

$autoLoader = new PsrAutoloader();
$autoLoader->addNamespace('Contentomat', INCLUDEPATHTOADMIN . "classes");
$autoLoader->addNamespace('Jakobus', PATHTOWEBROOT . "phpincludes/classes");

$ctl = new OrdersBackendController();
$content = $ctl->work();
?>
