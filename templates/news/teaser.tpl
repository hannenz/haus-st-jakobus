<article class="post post--teaser">
	<figure calss="post__image">
		<img src="/media/mlog/static/{VAR:post_image}" alt="" />
	</figure>
	{IF({ISSET:post_subtitle})}<h3 class="post__kicker">{VAR:post_subtitle}</h3>{ENDIF}
	<p class="post__meta">{VAR:post_date_fmt_date} &middot; {VAR:post_categories_fmt}</p>
	<h2 class="post__title">{VAR:post_title}</h2>
	<div class="post__teaser">{VAR:post_teaser}</div>
	<p class="post__link">
		<a href="{VAR:postDetailUrl}" class="button">weiter lesen …</a>
	</p>
</article>
