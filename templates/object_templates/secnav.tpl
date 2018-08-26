<nav class="secnav widget">
	<ul class="menu vertical" data-magellan data-offset="40">
		<li class="menu__item">
			<a class="menu__link" href="#top" title="Nach oben zum Seitenbeginn">{PAGETITLE}</a>
		</li>
		{LOOP NAVIGATION({PAGEID})}
			<li class="menu__item"><a class="menu__link" href="{NAVIGATION:link}">{NAVIGATION:title}</a></li>
		{ENDLOOP NAVIGATION}
	</ul>
</nav>
