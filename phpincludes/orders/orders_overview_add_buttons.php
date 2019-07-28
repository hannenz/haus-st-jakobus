<?php
/**
 * Add a button to toggle shipping status in order's overview
 * Code-Manager Event: before-show-row (Vor dem Anzeigen einer Zeile)
 *
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 * @version 2019-07-19
 */
namespace Jakobus;

$isShipped = ($cmtTableData['order_shipping_status'] == 'Versendet');

$button = sprintf('<a class="cmtIcon cmtIconShipped %s" href="%s&amp;action=orderToggleShipped&amp;id=%u" title="%s">%s</a>', 
	$isShipped ? 'cmtIconShipped--is-shipped' : '',
	SELFURL,
	$cmtTableData['id'],
	$isShipped ? 'Diese Bestellung als \'nicht versendet\' markieren' : 'Diese Bestellnug als \'versendet\' markieren',
	$isShipped ? 'Offen' : 'Versendet'
);

array_unshift($cmt_functions, $button);
?>
