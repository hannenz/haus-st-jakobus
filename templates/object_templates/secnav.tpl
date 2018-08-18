<nav class="secnav widget">
	<ul class="menu" data-magellan>
		{LOOP NAVIGATION({PAGEID})}
			<li class="menu__item"><a class="menu__link" href="{NAVIGATION:link}">{NAVIGATION:title}</a></li>
		{ENDLOOP NAVIGATION}
	</ul>
</nav>
