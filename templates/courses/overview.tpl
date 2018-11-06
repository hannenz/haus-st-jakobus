{LOOP VAR(categories)}
	<h2 class="headline">{VAR:course_category_name}</h2>
	{LOOP VAR(Courses)}
		<article class="course-teaser">
			<figure class="course-teaser__image">
				<img src="/media/courses/thumbnails/square/{VAR:course_image}" />
			</figure>
			<div class="course-teaser__body">
				<header class="course-teaser__header">
					<h2 class="headline course-teaser__headline">{VAR:course_title}</h2>
					<h3 class="subheadline course-teaser__subheadline">{VAR:course_subheadline}</h3>
					<div class="course-teaser__description">
						{VAR:course_short_description}
					</div>
				</header>

				<p class="course-teaser__action-area"> <a class="button" href="{VAR:course_detail_url}">Details</a></p>
			</div>
		</article>
	{ENDLOOP VAR}
{ENDLOOP VAR}
