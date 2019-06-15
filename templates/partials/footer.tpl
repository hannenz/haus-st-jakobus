{INCLUDE:PATHTOWEBROOT."phpincludes/corporate_data/corporate_data.php"}
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
					{LOOP NAVIGATION(97)}
						<li><a href="{NAVIGATION:link}">{NAVIGATION:title}</a></li>
					{ENDLOOP NAVIGATION}
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
