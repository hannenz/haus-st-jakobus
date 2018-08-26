<header class="main-header">
	<blockquote class="motto">Kommt und ruht ein wenig aus &hellip;</blockquote>

</header>

<nav class="main-nav">

	<a href="/" class="main-header__brand brand">
		<img class="brand__logo" src="/dist/img/logo.png" alt="" />
		<span class="brand__name">Haus St. Jakobus</span>
	</a>

	<ul class="main-nav__menu dropdown menu" data-dropdown-menu data-click-open="true" data-close-on-click-inside="true" data-disable-hover="false" data-closing-time="100ms">
		{LOOP NAVIGATION(1)}
		<li class="nav-item{IF("{NAVIGATION:id}" == "{PAGEID}")} current{ENDIF}">
			{IF("{NAVIGATION:children}" != "0")}
				<a href="javascript:void(0);" class="nav-item__link">{NAVIGATION:title}</a>
				<ul class="menu">
					{LOOP NAVIGATION({NAVIGATION:id})}
						<li class="nav-item">
							<a href="{NAVIGATION:link}" class="nav-item__link" title="">{NAVIGATION:title}</a>
						</li>
					{ENDLOOP NAVIGATION}
				</ul>
			{ELSE}
				<a href="{NAVIGATION:link}" class="nav-item__link" title="">{NAVIGATION:title}</a>
			{ENDIF}
		</li>
		{ENDLOOP NAVIGATION}
	</div>
</nav>
