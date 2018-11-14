<article class="news-teaser">
	<figure class="news-teaser__image">
		<a href="{VAR:postDetailUrl}"><img src="/media/mlog/static/thumbnails/square/{VAR:post_image}" alt="" /></a>
	</figure>
	<div class="news-teaser__body">
		<p class="news-teaser__meta">{VAR:post_date_fmt_date}</p>
		{IF({ISSET:post_subtitle})}<h3 class="news-teaser__kicker">{VAR:post_subtitle}</h3>{ENDIF}
		<h2 class="news-teaser__title">{VAR:post_title}</h2>
		<div class="news-teaser__teaser">{VAR:post_teaser}</div>
		<p class="news-teaser__link">
			<a class="more" href="{VAR:postDetailUrl}">weiter lesen</a>
		</p>
	</div>
</article>
