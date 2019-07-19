<?php
namespace Jakobus;
/**
 * Add a button to toggle shipping status
 * in order's overview
 *
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 * @version 2019-07-19
 */

use Contentomat\PsrAutoloader;
use Contentomat\Contentomat;
use Contentomat\CmtPage;
use Jakobus\Order;


$autoload = new PsrAutoloader();
$autoload->addNamespace("Contentomat", INCLUDEPATHTOADMIN . 'classes');
$autoload->addNamespace("Jakobus", PATHTOWEBROOT . 'phpincludes/classes');


// Is this safe?
$pageId = 24;


$CmtPage  = new CmtPage();
$Order = new Order();
$orderId = $cmtTableData['id'];

$order = $Order->findById($orderId);

$button = sprintf('<a class="cmtButton" href="//%s%s%s?action=orderToggleShipped&id=%u" title="%s">%s</a>', 
	$_SERVER['SERVER_NAME'],
	$CmtPage->makePageFilePath($pageId),
	$CmtPage->makePageFileName($pageId),
	$orderId,
	($order['order_shipping_status'] != 'shipped') ? 'Diese Bestellung als \'versendet\' markieren' : 'Diese Bestellnug als \'nicht versendet\' markieren',
	($order['order_shipping_status'] != 'shipped') ? 'Versendet' : 'Nicht versendet'
);

array_push($cmt_functions, $button);
?>
