<aside class="sidebar">
	<nav class="courses-by-category">
		<p>Nach Kategorie</p>
		<ul>
			{LOOP VAR(categories)}
				<li>
					<a href="{PAGEURL}?action=listByCategory&categoryId={VAR:id}">{VAR:course_category_name}</a>
				</li>
			{ENDLOOP VAR}
		</ul>
	</nav>
</aside>
<section class="main-content courses">
	{LOOP VAR(courses)}
		<article class="course">
			<header class="course__header">
				<h2 class="headline course__headline">{VAR:course_title}</h2>
				<h3 class="subheadline course_subheadline">{VAR:course_subheadline}</h3>
			</header>
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
				</dl>
				</dl>
				{LOOP VAR(course_events)}
					<dl class="course__detail event">
						<dt class="event__title">{VAR:media_title}</dt>
						<dd class="event__date">{VAR:event_date_begin_fmt} &ndash; {VAR:event_date_end_fmt}</dd>
					</dl>
				{ENDLOOP VAR}

			</footer>
		</article>
	{ENDLOOP VAR}
</section>
