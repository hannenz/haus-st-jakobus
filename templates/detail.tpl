<!doctype html>
<html class="no-js" lang="{PAGELANG}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{CONSTANT:POSTTITLE} - Cursillo-Haus St. Jakobus</title>
	<meta name="description" content="{PAGEVAR:cmt_meta_description:recursive}">
	<meta name="keywords" content="{PAGEVAR:cmt_meta_keywords:recursive}">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="/favicon.png" />

	<link rel="stylesheet" type="text/css" href="/dist/css/main.css" />

	<!-- TODO: ADD MICRODATA (JSONLD) -->

	{LAYOUTMODE_STARTSCRIPT}
	{IF (!{LAYOUTMODE})}
	<script type="text/javascript" src="/dist/js/vendor/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/foundation.min.js"></script>
	{ENDIF}
</head>
<body id="top" class="debug-base-line-grid--is-visible">
	<div class="outer-container">
		
		<div class="debug-base-line-grid"> </div>
		<!-- Inject SVG sprites -->
		<!-- <object type="image/svg+xml" data="/img/icons.svg" onload="this.parentNode.replaceChild(this.getSVGDocument().childNodes[0], this)"> </object> -->

		{INCLUDE:PATHTOWEBROOT.'templates/partials/header.tpl'}

		<div class="mood" style="background-image:url('{CONSTANT:MOODIMAGE}');"></div>


		<section class="main-container inner-bound">
			{INCLUDE:PATHTOWEBROOT."phpincludes/navigation/topbarnav_controller.php"}
				<div class="main-content">
					{LOOP CONTENT(1)}{ENDLOOP CONTENT}
				</div>
				<aside class="sidebar">
					{LOOP CONTENT(2)}{ENDLOOP CONTENT}
				</aside>
		</section>

		{INCLUDE:PATHTOWEBROOT.'templates/partials/footer.tpl'}
	</div>

	{IF(!{LAYOUTMODE})}
		<script src="/dist/js/main.min.js"></script>
	{ENDIF}
	{LAYOUTMODE_ENDSCRIPT}
</body>
</html>
