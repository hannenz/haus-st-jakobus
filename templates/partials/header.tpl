<header class="main-header">
	<!-- <blockquote class="motto">Kommt und ruht ein wenig aus &#38;hellip;</blockquote> -->
	<a href="/" class="main-header__brand brand">
		<img class="brand__logo" src="/dist/img/logo.png" alt="" />
		<h1 class="brand__name">Haus St. Jakobus</h1>
	</a>
	<div class="title-bar" data-responsive-toggle="haus-st-jakobus-menu" data-hide-for="large">
		<button onclick="document.getElementById('hamburger').classList.toggle('hidden');document.getElementById('cross').classList.toggle('hidden');" class="menu-trigger" type="button" data-toggle="haus-st-jakobus-menu">
			<svg class="" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
				<g id="hamburger">
					<line stroke="#fff" stroke-width="10" x1="0" y1="20" x2="100" y2="20" />
					<line stroke="#fff" stroke-width="10" x1="0" y1="50" x2="100" y2="50" />
					<line stroke="#fff" stroke-width="10" x1="0" y1="80" x2="100" y2="80" />
				</g>
				<g id="cross" class="hidden">
					<line stroke="#fff" stroke-width="10" x1="10" y1="15" x2="90" y2="85" />
					<line stroke="#fff" stroke-width="10" x1="10" y1="85" x2="90" y2="15" />
				</g>
			</svg>
		</button>
	</div>
</header>

<nav class="main-nav">

	<div class="top-bar" id="haus-st-jakobus-menu">
		<div class="top-bar-right">
			<ul class="main-nav__menu vertical large-horizontal menu" data-responsive-menu="drilldown large-dropdown" data-click-open="true" data-close-on-click-inside="true" data-disable-hover="true" data-closing-time="100ms">
				{LOOP NAVIGATION(1)}
					<li class="nav-item{IF({NAVIGATION:isancestor})} current{ENDIF}">
						{IF("{NAVIGATION:children}" != "0")}
							<a href="javascript:void(0);" class="nav-item__link">{NAVIGATION:title}</a>
							<ul class="vertical menu">
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
			</ul>
		</div>
	</div>
</nav>
