<!doctype html>
<html class="no-js" lang="{PAGELANG}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{PAGETITLE} - Cursillo-Haus St. Jakobus</title>

	{INCLUDE:PATHTOWEBROOT . "templates/partials/meta.tpl"}

	<link rel="shortcut icon" href="/dist/img/favicon.png" />

	<link rel="stylesheet" href="/dist/css/vendor/leaflet.css">
	<link rel="stylesheet" type="text/css" href="/dist/css/main.css" />

	<link rel="canonical" href="{CANONICALURL}" />

	{LAYOUTMODE_STARTSCRIPT}
	{IF (!{LAYOUTMODE})}
	<script type="text/javascript" src="/dist/js/vendor/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/foundation.min.js"></script>
	<script src="/dist/js/vendor/jquery.brightbox.js"></script>
	<script src="/dist/js/vendor/leaflet.js"></script> 
	<script src="/dist/js/vendor/lazyload.min.js"></script>
	{ENDIF}
</head>
<body id="top" class="debug-base-line-grid--is-visible">
	<div class="outer-container">
		
		{INCLUDE:PATHTOWEBROOT.'templates/partials/header.tpl'}

		{IF("{PAGEID}" == "2")}
			{INCLUDE:PATHTOWEBROOT.'phpincludes/slider/homepageslider_controller.php'}
		{ELSE}
			<div class="mood" style="background-image:url('/media/mood/{PAGEVAR:jakobus_mood:recursive}');"></div>
		{ENDIF}


		<div class="main-container-wrapper">
			{INCLUDE:PATHTOWEBROOT.'phpincludes/navigation/topbarnav_controller.php'}
			<section id="main-container" class="main-container inner-bound" data-sticky-container>
					<div class="main-content">
						{LOOP CONTENT(1)}{ENDLOOP CONTENT}
					</div>
					<aside class='sidebar'>
						<div{IF("{PAGEVAR:jakobus_sidebar_is_pinned}" == "1")} class="sticky" data-sticky data-sticky-on="large" data-margin-top="5" data-anchor="main-container"{ENDIF}>
							{INCLUDE:PATHTOWEBROOT.'phpincludes/pilgrimpasses/cart_controller.php'}
							{LOOP CONTENT(2)}{ENDLOOP CONTENT}
						</div>
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
