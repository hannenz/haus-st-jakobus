<header class="main-header">
	<nav class="main-nav">

		<a href="/" class="main-header__brand brand">
			<img class="brand__logo" src="/dist/img/logo.png" alt="" />
			<span class="brand__name">Haus St. Jakobus</span>
		</a>

		<ul class="main-nav__menu dropdown menu" data-dropdown-menu data-click-open="true" data-disable-hover="true">
			{LOOP NAVIGATION(1)}
			<li class="nav-item{IF("{NAVIGATION:id}" == "{PAGEID}")} current{ENDIF}">
				<a href="{NAVIGATION:link}" class="nav-item__link" title="">{NAVIGATION:title}</a>
				{IF("{NAVIGATION:children}" != "0")}
					<ul class="menu">
						{LOOP NAVIGATION({NAVIGATION:id})}
							<li class="nav-item">
								<a href="{NAVIGATION:link}" class="nav-item__link" title="">{NAVIGATION:title}</a>
							</li>
						{ENDLOOP NAVIGATION}
					</ul>
				{ENDIF}
			</li>
			{ENDLOOP NAVIGATION}
		</div>
	</nav>
</header>


