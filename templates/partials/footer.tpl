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
	$cdClaim = $CorporateData->getField('claim');
}
catch (\Exception $e) {
	die ($e->getMessage());
}
{ENDEVAL}
 <figure class="map">
	 <div id="map"></div>
 </figure>

<footer class="main-footer">
	<div class="main-footer__inner inner-bound">
		<div class="footer-column">
			<address>
				<p>
					{USERVAR:cdOrgName}<br>
					{USERVAR:cdStreetAddress}<br>
					{USERVAR:cdCountry}&ndash;{USERVAR:cdZip} {USERVAR:cdCity}
				</p>
				<p>
					{USERVAR:cdPhone}<br>
					<a href="mailtp:{USERVAR:cdEmail}">{USERVAR:cdEmail}</a>
				</p>
			</address>
		</div>
		<div class="footer-column">
			<nav>
				<ul>
					<li><a href="{PAGEURL:25}">Der Weg</a></li>
					<li><a href="{PAGEURL:92}">Das Haus</a></li>
					<li><a href="{PAGEURL:61}">Förderverein</a></li>
					<li><a href="{PAGEURL:24}">Pilgerausweise</a></li>
					<li><a href="{PAGEURL:39}">Programm</a></li>
				</ul>
			</nav>
		</div>
		<div class="footer-column">
			<blockquote>
				{USERVAR:cdClaim:nl2br}
			</blockquote>
			<nav class="legal-nav">
				{LOOP NAVIGATION(40)}
					<a href="{NAVIGATION:link}">{NAVIGATION:title}</a>
				{ENDLOOP NAVIGATION}
			</nav>
		</div>
	</div>
</footer>
