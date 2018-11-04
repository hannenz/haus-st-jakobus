<?php
namespace Jakobus;

use Jakobus\Thumbnailer;
use Contentomat\PsrAutoloader;

$autoLoad = new PsrAutoloader();
$autoLoad->addNamespace('Jakobus', PATHTOWEBROOT . "phpincludes/classes");

$thumbnailer = new Thumbnailer('mlog_posts', 'post_image');
$success = $thumbnailer->createThumbnails([
	[
		'width' => 480,
		'dir' => 'thumbnails'
	],
	[
		'width' => 320,
		'dir' => 'thumbnails/square',
		'square' => true
	]
]);

if (!$success) {
	// $cmt_usermessage = $thumbnailer->getErrorMessage();
	// $cmt_abortsave = true;
}
?>

