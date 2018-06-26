<!doctype html>
<html class="no-js" lang="{PAGELANG}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{PAGETITLE} - Haus St. Jakobus</title>
	<meta name="description" content="{PAGEVAR:cmt_meta_description:recursive}">
	<meta name="keywords" content="{PAGEVAR:cmt_meta_keywords:recursive}">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="/favicon.png" />

	<link rel="stylesheet" type="text/css" href="/dist/css/main.css" />

	{LAYOUTMODE_STARTSCRIPT}
	{IF (!{LAYOUTMODE})}
	<script type="text/javascript" src="/js/vendor/modernizr/modernizr.custom.js"></script>
	{ENDIF}
</head>
<body class="debug-base-line-grid--is-visible">
	<div class="debug-base-line-grid"> </div>
	<!-- Inject SVG sprites -->
	<!-- <object type="image/svg+xml" data="/img/icons.svg" onload="this.parentNode.replaceChild(this.getSVGDocument().childNodes[0], this)"> </object> -->

	{INCLUDE:PATHTOWEBROOT.'templates/partials/header.tpl'}

	{IF("{PAGEID}" == "2")}
	<div class="hero">
		<blockquote class="hero__title">
			Kommt und ruht ein wenig aus &hellip;
		</blockquote>
	</div>
    {ELSE}
        <div class="mood"></div>
	{ENDIF}

	<section class="main-container inner-bound">
		<div class="main-content">
			{LOOP CONTENT(1)}{ENDLOOP CONTENT}
		</div>
		<aside class="sidebar">
			{LOOP CONTENT(2)}{ENDLOOP CONTENT}
		</aside>
	</section>

	{INCLUDE:PATHTOWEBROOT.'templates/partials/footer.tpl'}

	{IF(!{LAYOUTMODE})}
		<script src="dist/js/main.js"></script>
	{ENDIF}
	{LAYOUTMODE_ENDSCRIPT}
</body>
</html>
