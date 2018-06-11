<header class="main-header">
	<nav class="main-nav">
		<a href="/" class="main-header__brand brand">
			<img class="brand__logo" src="/dist/img/logo.png" alt="" />
			<span class="brand__name">Haus St. Jakobus</span>
		</a>
		<ul class="main-nav__menu">
			{LOOP NAVIGATION(1)}
			<li class="nav-item{IF("{NAVIGATION:id}" == "{PAGEID}")} current{ENDIF}"><a href="{NAVIGATION:link}" class="nav-item__link" title="">{NAVIGATION:title}</a></li>
			{ENDLOOP NAVIGATION}
		</div>
	</nav>
</header>


