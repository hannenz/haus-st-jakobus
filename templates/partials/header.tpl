<header class="main-header">
	<div class="main-header__top">
		<div class="main-header__inner inner-bound">
			<blockquote class="main-header__quote">
				&bdquo;Kommt und ruht ein wenig aus &hellip;&rdquo;
			</blockquote>
			<a href="/" class="main-header__brand brand">
				<img class="brand__logo" src="/dist/img/logo.png" alt="" />
				<span class="brand__name">Haus St. Jakobus</span>
			</a>
		</div>
	</div>
	<nav class="main-nav">
		<div class="inner-bound">
			{LOOP NAVIGATION(1)}
				<a href="{NAVIGATION:link}" title="">{NAVIGATION:title}</a>
			{ENDLOOP NAVIGATION}
		</div>
	</nav>
</header>


