{EVAL}

use Contentomat\PsrAutoloader;
use Jakobus\CorporateData;

$autoLoader = new PsrAutoloader();
$autoLoader->addNamespace('Jakobus', PATHTOWEBROOT . "phpincludes/classes");

try {
	$CorporateData = new CorporateData();
	$cdOrgName = $CorporateData->getField('address_organization');
	$cdStreetAddress = $CorporateData->getField('address_street_address');
	$cdZip = $CorporateData->getField('address_zip');
	$cdCity = $CorporateData->getField('address_city');
	$cdCountry = $CorporateData->getField('address_country');
}
catch (\Exception $e) {
	die ($e->getMessage());
}
{ENDEVAL}
<footer class="main-footer">
	<div class="main-footer__inner inner-bound">
		<div class="footer-column">
			<address>
				<p>
					{USERVAR:cdOrgName}<br>
					{USERVAR:cdStreetAddress}<br>
					{USERVAR:cdCountry}&ndash;{USERVAR:cdZip} {USERVAR:cdCity}
					<!--
					Cursillo-Haus St. Jakobus<br>
					Kapellenberg 58&ndash;60<br>
					D&ndash;89610 Oberdischingen
					-->
				</p>
				<p>
					07305&thinsp;&ndash;&thinsp;919&thinsp;575<br>
					<a href="mailto:info@haus-st-jakobus.de">info@haus-st-jakobus.de</a>
				</p>
			</address>
		</div>
		<div class="footer-column">
			<nav>
				<ul>
					<li><a href="{PAGEURL:99}">Der Weg</a></li>
					<li><a href="{PAGEURL:7}">Das Haus</a></li>
					<li><a href="{PAGEURL:99}">Förderverein</a></li>
					<li><a href="{PAGEURL:24}">Pilgerausweise</a></li>
					<li><a href="{PAGEURL:39}">Programm</a></li>
				</ul>
			</nav>
		</div>
		<div class="footer-column">
			<blockquote>
				Gastfreundschaft, Begegnung, Einfachheit, Heimat, Natur, Offenheit, Spiritualität, Achtsamkeit, Ort der Mitte
			</blockquote>
			<nav class="legal-nav">
				{LOOP NAVIGATION(40)}
					<a href="{NAVIGATION:link}">{NAVIGATION:title}</a>
				{ENDLOOP NAVIGATION}
			</nav>
		</div>
	</div>
</footer>
