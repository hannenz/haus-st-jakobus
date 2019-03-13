<article class="teaser teaser--course">

	<figure class="teaser__image">
		<a href="{VAR:course_detail_url}"> 
			<img src="/media/courses/thumbnails/square/{VAR:course_image}" /> 
		</a>
	</figure>

	<div class="teaser__body">
		<header class="teaser__header">

			<a href="{VAR:course_detail_url}"><h2 class="headline">{VAR:course_title}</h2></a>
			{IF({ISSET:course_subheadline})} <h3 class="subheadline teaser__subheadline">{VAR:course_subheadline}</h3>{ENDIF}
			<div class="teaser__text">
				{VAR:course_short_description}
			</div>
		</header>

		<p class="teaser__action-area">
			<a class="more" href="{VAR:course_detail_url}">Details</a>
		</p>
	</div>
</article>
