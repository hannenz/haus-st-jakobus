<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>{PAGETITLE}</title>
		<link rel="stylesheet" type="text/css" href="/dist/css/vendor/newsletter.css">
		{LAYOUTMODE_STARTSCRIPT}
	</head>
	<body id="newsletter">
		<table id="nl-body-container">
			<tr>
				<td id="nl-header-wrapper">
					<table id="nl-header">
						<tr>
							<td id="nl-logo">
								<img src="/dist/img/logo.png" alt="Haus St. Jakobus" width="75" height="63" />
							</td>
							<td id="nl-brand">
								<span id="brand">Cursillo-Haus St. Jakobus</span><br>
								<span id="sub-brand">Newsletter 01/2019</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td id="nl-webversion-link">
					{EVAL}
					$host = $_SERVER['SERVER_NAME'];
					{ENDEVAL}
					<a href="https://{USERVAR:host}{PAGEURL:{PAGEID}}">Web-Version</a>
				</td>
			</tr>
			<tr>
				<td id="nl-main-content">
					{LOOP CONTENT(1)} {ENDLOOP CONTENT}
				</td>
			</tr>
			<tr>
				<td id="nl-footer-wrapper">
					<table id="nl-footer">
						<tr>
							<td>
								<p>
									Haus St. Jakobus<br>
									Schwäbische Jakobusgesellschaft<br>
									Kapellenweg 58&thinsp;&mdash;&thinsp;60<br>
									D-89610 Oberdischingen
								</p>
							</td>
							<td>
								<p>
									<a href="https://www.haus-st-jakobus.de">www.haus-st-jakobus.de</a><br>
									<a href="https://www.haus-st-jakobus.de/impressum">Impressum</a><br>
									<a href="https://www.haus-st-jakobus.de/unsubscribe">Abmelden</a>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
	{LAYOUTMODE_ENDSCRIPT}
</html>
