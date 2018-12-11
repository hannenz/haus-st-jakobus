<nav class="secnav widget">
	<div class="widget__header">
		<div class="menu__item">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
				<path d="m0,100 H 100,100 L 50,0Z">
			</svg>
			<a href="#top" title="Nach oben zum Seitenbeginn">{PAGETITLE}</a>
		</div>
	</div>
	<div class="widget__body">
		<ul class="menu vertical" data-magellan data-offset="0" data-threshold="100" data-animation-duration="350">
			{LOOP NAVIGATION({PAGEID})}
				<li class="menu__item"><a class="menu__link" href="{NAVIGATION:link}" onclick="this.blur();">{NAVIGATION:title}</a></li>
			{ENDLOOP NAVIGATION}
		</ul>
	</div>
</nav>
