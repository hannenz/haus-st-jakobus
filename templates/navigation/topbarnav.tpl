<nav class="breadcrumbs-navigation">
	<ul class="breadcrumbs">
		<li><span>{VAR:current}</span></li>
		{LOOP VAR(siblings)}
			<li>
				{IF("{VAR:id}" == "{PAGEID}")}
					<span>{VAR:cmt_title}</span>
				{ELSE}
					<a href="{VAR:linkUrl}">{VAR:cmt_title}</a>
				{ENDIF}
			</li>
		{ENDLOOP VAR}
	</ul>
</nav>
