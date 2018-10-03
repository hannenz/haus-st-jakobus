		<article class="course">
			<header class="course__header">
				<h2 class="headline course__headline">{VAR:course_title}</h2>
				<h3 class="subheadline course_subheadline">{VAR:course_subheadline}</h3>
			</header>
			<figure class="course__image">
				<img src="/media/courses/{VAR:course_image}" alt="" title="" />
			</figure>
			<div class="course__description">
				{VAR:course_description}
			</div>

			<footer class="course__footer">
				{IF({ISSET:course_elements})}
					<dl class="course__detail">
						<dt>Elemente</dt>
						<dd>{VAR:course_elements}</dd>
					</dl>
				{ENDIF}
				<dl class="course__detail">
					<dt>Leitung</dt>
					<dd>{VAR:course_instructor}</dd>
					<dt>Kosten</dt>
					<dd>
						{VAR:course_costs_fmt}
					</dd>
				</dl>
				{LOOP VAR(course_events)}
					<dl class="course__detail event">
						<dt class="event__title">{VAR:media_title}</dt>
						<dd class="event__date">{VAR:event_date_begin_fmt} &ndash; {VAR:event_date_end_fmt}</dd>
					</dl>
					<div>
						<a class="button" href="{VAR:event_subscribe_url}">Anmelden</a>
					</div>
				{ENDLOOP VAR}

			</footer>
		</article>
