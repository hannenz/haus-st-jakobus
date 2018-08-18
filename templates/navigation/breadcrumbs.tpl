<nav class="breadcrumbs-navigation">
	<ul class="breadcrumbs">
		{LOOP VAR(breadcrumbs)}
			<li>
				{IF("{PAGEID}" == "{VAR:id}")}
					<span>{VAR:cmt_title}</span>
				{ELSE}
					<a href="{VAR:url}">{VAR:cmt_title}</a>
				{ENDIF}
				</li>
		{ENDLOOP VAR}
	</ul>
</nav>
