<article class="course">
	{IF({ISSET:templates:VAR})}
		{LOOP VAR(templates)}
			{VAR:cmt_source}
			{NEXTTEMPLATE}
		{ENDLOOP VAR}
	{ELSE}
		<!-- <figure class="course__image"> -->
		<!-- 	<img src="/media/courses/{VAR:course_image}" alt="" title="" /> -->
		<!-- </figure> -->
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
				{IF({ISSET:course_instructor})}
					<dt>Leitung</dt>
					<dd>{VAR:course_instructor}</dd>
				{ENDIF}
				{IF({ISSET:course_costs_fmt})}
					<dt>Kosten</dt>
					<dd>{VAR:course_costs_fmt}</dd>
				{ENDIF}
			</dl>
			{IF("{COUNT:course_events}" != "0")}
			<table class="table course__events">
				<caption>Termine</caption>
				
				{LOOP VAR(course_events)}
				<tr>
					<td class="event__date">{VAR:event_date_fmt}</td>
					<td>

						{IF({ISSET:event_title:VAR})}<h3 class="event__title">{VAR:event_title}</h3>{ENDIF}

						{IF(!empty("{VAR:event_remark}"))}<div class="event_remark">{VAR:event_remark}</div>{ENDIF}
						{IF("{VAR:event_needs_registration}" == "1")}

							<p>
							{INCLUDE:PATHTOWEBROOT.'templates/partials/availability_indicator.tpl'}
							{IF("{VAR:event_seats_available}" > "0")}
								Noch {VAR:event_seats_available} Plätze frei
							{ELSE}
								Diese Veranstaltung ist ausgebucht
							{ENDIF}
							<p>

							{IF("{VAR:event_registration_before}" != "0000-00-00")}
								<p>Anmeldung erforderlich bis {VAR:event_registration_before_fmt}</p>
							{ENDIF}
						{ELSE}
							<div>Eine Anmeldung ist nicht erforderlich</div>
						{ENDIF}
					</td>
					<td>
						<!-- <a class="more" href="{VAR:event_detail_url}">Details</a><br> -->
						<a class="more" href="{VAR:event_subscribe_url}">Anmelden</a>
					</td>
				</tr>
				{ENDLOOP VAR}
			</table>
			{ENDIF}
		</footer>
	{ENDIF}
</article>
