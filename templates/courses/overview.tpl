	{LOOP VAR(courses)}
		<article class="course media-object stack-for-small">
			<figure class="course__image media-object-section">
				<img src="/media/courses/thumbnails/square/{VAR:course_image}" />
			</figure>
			<div class="media-object-section">
				<header class="course__header media-object-section">
					<h2 class="headline course__headline">{VAR:course_title}</h2>
					<h3 class="subheadline course_subheadline">{VAR:course_subheadline}</h3>
					<div class="course__description">
						{VAR:course_short_description}
					</div>
				</header>

				<p> <a class="button" href="{VAR:course_detail_url}">Details</a></p>
			</div>

		</article>
	{ENDLOOP VAR}
