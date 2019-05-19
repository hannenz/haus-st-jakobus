<?php
/**
 * phpincludes/pilgrimpasses/order_pilgrimpasses.php
 * 
 * Render an order's set of pilgrimpasses 
 * in CMT backend orders table
 * This script is embedded in "Tabellenstruktur" of
 * table `jakobus_orders` ("Bestellungen")
 *
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 */
namespace Jakobus;

use Contentomat\Contentomat;
use Contentomat\PsrAutoloader;
use Contentomat\Controller;
use Contentomat\Parser;
use Jakobus\Pilgrimpass;
use Jakobus\Order;

$orderId = $_GET['id'][0];

$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . 'phpincludes/classes');
$autoLoad->addNamespace('Contentomat', INCLUDEPATHTOADMIN . 'classes');

$Pilgrimpass = new Pilgrimpass();
$passes = $Pilgrimpass->filter([
	'pilgrimpass_order_id' => $orderId
])->findAll();

$Parser = new Parser();
$Parser->setParserVar('passes', $passes);

$pilgrimpassesContent = $Parser->parseTemplate(PATHTOWEBROOT."templates/pilgrimpasses/orders_pilgrimpasses.tpl");
?>
