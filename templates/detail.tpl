<!doctype html>
<html class="no-js" lang="{PAGELANG}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{CONSTANT:POSTTITLE} - Cursillo-Haus St. Jakobus</title>

	{INCLUDE:PATHTOWEBROOT . "templates/partials/meta.tpl"}

	<link rel="shortcut icon" href="/favicon.png" />

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/main.css" />

	<link rel="canonical" href="{CANONICALURL}" />

	{LAYOUTMODE_STARTSCRIPT}
	{IF (!{LAYOUTMODE})}
	<script type="text/javascript" src="/dist/js/vendor/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/foundation.min.js"></script>
	<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script> 
	<script src="/dist/js/vendor/lazyload.min.js"></script>
	{ENDIF}
</head>
<body id="top" class="debug-base-line-grid--is-visible">
	<div class="outer-container">
		
		{INCLUDE:PATHTOWEBROOT.'templates/partials/header.tpl'}

		<div class="mood" style="background-image:url('{CONSTANT:MOODIMAGE}');"></div>


		<div class="main-container-wrapper">
			{INCLUDE:PATHTOWEBROOT."phpincludes/navigation/topbarnav_controller.php"}
			<section class="main-container inner-bound">
				<div class="main-content">
					{LOOP CONTENT(1)}{ENDLOOP CONTENT}
				</div>
				<aside class="sidebar">
					{LOOP CONTENT(2)}{ENDLOOP CONTENT}
				</aside>
			</section>
		</div>

		{INCLUDE:PATHTOWEBROOT.'templates/partials/footer.tpl'}
	</div>

	{IF(!{LAYOUTMODE})}
		<script src="/dist/js/main.min.js"></script>
	{ENDIF}
	{LAYOUTMODE_ENDSCRIPT}
</body>
</html>

