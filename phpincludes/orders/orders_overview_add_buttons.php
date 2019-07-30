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

$isShipped = ($cmtTableDataRaw['order_shipping_status'] == 'shipped');
$id = $cmtTableDataRaw['id'];

$button = sprintf('<span><input id="order-shipped-cb-%u" type="checkbox" %s onchange=\'window.location="%s&amp;action=orderToggleShipped&amp;id=%u";\' /><label for="order-shipped-cb-%u">Versendet</label></span>',
	$id,
	$isShipped ? 'checked' : '',
	SELFURL,
	$id,
	$id
);

array_unshift($cmt_functions, $button);
?>
