<article class="course">
	{IF({ISSET:templates:VAR})}
		{LOOP VAR(templates)}
			{VAR:cmt_source}
			{NEXTTEMPLATE}
		{ENDLOOP VAR}
	{ELSE}
		<header class="course__header">
			<h2 class="headline course__headline">{VAR:course_title}</h2>
			{IF({ISSET:course_subheadline})}<h3 class="subheadline course_subheadline">{VAR:course_subheadline}</h3>{ENDIF}
		</header>
		<div class="course__description">
			{VAR:course_description}
		</div>

		<div class="course__images">
			{LOOP VAR(images)}
				<figure>
					<img src="/media/courses/{VAR:media_image_file_internal}" alt="" />
				</figure>
			{ENDLOOP VAR}
		</div>

		<footer class="course__footer">
			{IF({ISSET:course_elements})}
				<dl class="course__detail">
					<dt>Elemente</dt>
					<dd>{VAR:course_elements}</dd>
				</dl>
			{ENDIF}
			<dl class="course__detail">
				{IF({ISSET:course_instructor})}
					<dt>Leitung</dt>
					<dd>{VAR:course_instructor}</dd>
				{ENDIF}
				{IF({ISSET:course_costs_fmt})}
					<dt>Kosten</dt>
					<dd class="course_costs">{VAR:course_costs_fmt}</dd>
				{ENDIF}
			</dl>
			{IF("{COUNT:course_events}" != "0")}
				{LOOP VAR(course_events)}
					{INCLUDE:PATHTOWEBROOT."templates/events/teaser.tpl"}
				{ENDLOOP VAR}
			{ENDIF}

			<a href="{VAR:course_overview_url}" class="back">Zurück</a>
		</footer>
	{ENDIF}
</article>
