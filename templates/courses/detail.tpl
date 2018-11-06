<article class="course">
	{IF({ISSET:templates:VAR})}
		{LOOP VAR(templates)}
			{VAR:cmt_source}
			{NEXTTEMPLATE}
		{ENDLOOP VAR}
	{ELSE}
		<figure class="course__image">
			<img src="/media/courses/{VAR:course_image}" alt="" title="" />
		</figure>
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
				<dt>Kosten</dt>
				<dd>
					{VAR:course_costs_fmt}
				</dd>
				<dt>Termine</dt>
				<dd>
					<table class="table">
						{LOOP VAR(course_events)}
						<tr>
							<td>
								<dt class="event__title">{VAR:event_title}</dt>
								<dd class="event__date">{VAR:event_date_fmt}</dd>
								{IF(!empty("{VAR:event_remark}"))}<dd class="event_remark">{VAR:event_remark}</dd>{ENDIF}
								{IF("{VAR:event_needs_registration}" == "1")}
									<dd>Noch {VAR:EventSeatsLeft} Plätze frei</dd>
									<dd>Anmeldung erforderlich bis {VAR:event_registration_before_fmt}</dd>
								{ELSE}
									<dd>Eine Anmeldung ist nicht erforderlich</dd>
								{ENDIF}
							</td>
							<td style="text-align:right;">
								<a class="button" href="{VAR:event_subscribe_url}">Anmelden</a>
							</td>
						</tr>
						{ENDLOOP VAR}
					</table>
				</dd>
			</dl>
		</footer>
	{ENDIF}
</article>
