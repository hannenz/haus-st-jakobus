<div class="news news--latest">
	{LOOP VAR(posts)}
		{INCLUDE:PATHTOWEBROOT.'templates/news/teaser.tpl'}
	{ENDLOOP VAR}
</div>


<nav aria-label="Pagination">
	<ul class="pagination">
		{IF({ISSET:prevPageUrl})}<li class="pagination-previous disabled"><a href="{VAR:prevPageUrl}">Neuere Artikel</a></li>{ENDIF}
		{LOOP VAR(pagingLinks)}
			<li class="{IF("{VAR:isCurrent}" == "1")}current{ENDIF}">
				<a href="{VAR:pagingLink}">{VAR:iter}</a>
			</li>
		{ENDLOOP VAR}
		{IF({ISSET:nextPageUrl})}<li class="pagination-next"><a href="{VAR:nextPageUrl}">Ältere Artikel</a></li>{ENDIF}
	</ul>
</nav>
