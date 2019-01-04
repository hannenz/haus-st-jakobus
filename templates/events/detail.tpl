<figure>
	{IF({ISSET:event_image})}
		<img src="/media/events/thumbnails/square/{VAR:event_image}" alt="" />
	{ELSE}
		{IF({ISSET:course_image})}
			<img src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
		{ENDIF}
	{ENDIF}
</figure>
<table class="table">
		{IF("{VAR:event_course_id}" != "0")}
			<tr>
				<th>Kurs</th>
				<td><a href="{VAR:course_detail_url}">{VAR:course_title}</a></td>
			</tr>
		{ENDIF}
		<tr>
			<th align="left">Titel</th>
			<td>{VAR:event_title}</td>
		</tr>
		<tr>
			<th align="left">Datum</th>
			<td>{VAR:event_date_fmt}</td>
		</tr>
		<tr>
			<th align="left">Anmeldung erforderlich</th>
			<td>{IF("{VARL:event_needs_registration}" == "1")}Ja{ELSE}Nein{ENDIF}</td>
		</tr>
		{IF("{VAR:event_needs_registration}" == "1")}
			{IF("{VAR:event_registration_before}" != "0000-00-00")}
			<tr>
				<th align="left">Anmeldung erforderlich bis</th>
				<td>{VAR:event_registration_before_fmt}</td>
			</tr>
			{ENDIF}
			<tr>
				<th align="left">Plätze</th>
				<td>{VAR:event_seats_max}</td>
			</tr>
			<tr>
				<th align="left">freie Plätze</th>
				<td>{VAR:event_seats_available}</td>
			</tr>
			<tr>
				<th align="left">Mindestteilnehmeranzahl</th>
				<td>{VAR:event_seats_min}</td>
			</tr>
		{ENDIF}
		<tr>
			<th align="left">Typ</th>
			<td>{VAR:event_type}</td>
		</tr>
		<tr>
			<th align="left">Abendveranstaltung</th>
			<td>{IF("{VAR:event_is_soiree}")}Ja{ELSE}Nein{ENDIF}</td>
		</tr>
		<tr>
			<th align="left">Ort</th>
			<td>{VAR:event_location}</td>
		</tr>
		{IF({ISSET:event_remark})}
		<tr>
			<th align="left">Anmerkungen</th>
			<td>{VAR:event_remark:nl2br}</td>
		</tr>
		{ENDIF}
</table>

<p>
	{IF("{VAR:event_can_registrate}" == "1")}
		<a class="subscribe more" href="{VAR:event_subscribe_url}">Anmelden</a>
	{ENDIF}
</p>
