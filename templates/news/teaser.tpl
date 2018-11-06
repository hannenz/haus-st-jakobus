<article class="post-teaser">
	<figure class="post-teaser__image">
		<a href="{VAR:postDetailUrl}"><img src="/media/mlog/static/thumbnails/square/{VAR:post_image}" alt="" /></a>
	</figure>
	<div class="post-teaser__body">
		<p class="post-teaser__meta">{VAR:post_date_fmt_date} &middot; {VAR:post_categories_fmt}</p>
		{IF({ISSET:post_subtitle})}<h3 class="post__kicker">{VAR:post_subtitle}</h3>{ENDIF}
		<h2 class="post-teaser__title">{VAR:post_title}</h2>
		<div class="post-teaser__teaser">{VAR:post_teaser}</div>
		<p class="post-teaser__link">
			<a href="{VAR:postDetailUrl}" class="button">weiter lesen …</a>
		</p>
	</div>
</article>
