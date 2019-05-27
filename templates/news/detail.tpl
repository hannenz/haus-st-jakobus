<article class="post post--detail">

	<p class="post__meta">{VAR:post_date_fmt_date}</p>
	<h3 class="post__kicker">{VAR:post_subtitle}</h2>
	<h2 class="post__title">{VAR:post_title}</h2>
	<div class="post__text">{VAR:post_text}</div>


	{IF("{VAR:hasLink}" != "0")}
		<ul class="post__links bullets">
			{LOOP VAR(links)}
				<li><a href="{VAR:media_url}">{VAR:media_title}</a></li>
			{ENDLOOP VAR}
		</ul>
	{ENDIF}

	{IF("{VAR:hasImage}" != "0")}
		<div class="post__media">
			{LOOP VAR(images)}
				<figure class="post-image">
					<img src="/media/mlog/{VAR:media_internal_filename}" alt="" />
					{IF({ISSET:media_title:VAR})}
						<figcaption class="post-image__caption">
							{VAR:media_title}
						</figcaption>
					{ENDIF}
				</figure>
			{ENDLOOP VAR}
		</div>
	{ENDIF}


	<p><a  class="back" href="{VAR:postOverviewUrl}">Zurück zur Übersicht</a></p>

</article>
