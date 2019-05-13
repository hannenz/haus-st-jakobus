<article class="teaser teaser--news">

	<figure class="teaser__image">
		<a href="{VAR:postDetailUrl}">
			<img src="/media/mlog/static/thumbnails/square/{VAR:post_image}" alt="" />
		</a>
	</figure>

	<div class="teaser__body">
		<header class="teaser__header">
			<div class="teaser__meta">
				{VAR:post_date_fmt_date}
			</div>
			{IF({ISSET:post_subtitle})}<h3 class="kicker">{VAR:post_subtitle}</h3>{ENDIF}
			<h2 class="headline">{VAR:post_title}</h2>
			<div class="teaser__text">
				{VAR:post_teaser}
			</div>
		</header>

		<p class="teaser__action-area">
			<a class="more" href="{VAR:postDetailUrl}">weiter lesen</a>
		</p>
	</div>
</article>
