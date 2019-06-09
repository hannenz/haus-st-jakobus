<!doctype html>
<html class="no-js" lang="{PAGELANG}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{CONSTANT:POSTTITLE} - Cursillo-Haus St. Jakobus</title>

	{INCLUDE:PATHTOWEBROOT . "templates/partials/meta.tpl"}

	<link rel="shortcut icon" href="/favicon.png" />

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
	<link rel="stylesheet" type="text/css" href="/dist/css/main.css" />

	{LAYOUTMODE_STARTSCRIPT}
	{IF (!{LAYOUTMODE})}
	<script type="text/javascript" src="/dist/js/vendor/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="/dist/js/vendor/foundation.min.js"></script>
	<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script> 
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

