<section class="courses-by-category">
	<h2 class="headline no-headline--large">Kurse nach Kategorie</h2>
	<ul>
		{LOOP VAR(categories)}
			<li>
				<h3>{VAR:course_category_name}</h3>
				<dl>
					<h4>Kurse</h4>
					<ul>
						{LOOP VAR(Courses)}
						<li>
							<h5><a href="{VAR:course_detail_url}">{VAR:course_title}</a></h5>
							<h6>Termine</h6>
							<ul>
								{LOOP VAR(course_events)}
									<li>{VAR:event_date_fmt}</li>
								{ENDLOOP VAR}
							</ul>
						</li>
						{ENDLOOP VAR}
					</ul>
				</dl>
			</li>
		{ENDLOOP VAR}
	</ul>
</section>
