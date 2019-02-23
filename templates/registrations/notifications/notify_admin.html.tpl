<p>Eine Anmeldung ist eingegangen</p>

<dl>
	<dt>Name</dt>			<dd>{VAR:registration_salutation} {VAR:registration_firstname} {VAR:registration_lastname}</dd>
	<dt>Anschrift</dt> 		<dd>{VAR:registration_street_address}<br>
								{VAR:registration_zip} {VAR:registration_city}</dd>
	<dt>Telefon</dt> 		<dd>{VAR:registration_phone}</dd>
	<dt>E-Mail</dt> 		<dd>{VAR:registration_email}</dd>
	<dt>Geburtstag</dt> 	<dd>{VAR:registration_birthday}</dd>
	<dt>Mitglied im Förderverein</dt> <dd>{IF("{VAR:registration_is_member}" == "1")}Ja{ELSE}Nein{ENDIF}</dd>
</dl>

<dl>
<dt>Kurs</dt> <dd><dd>{VAR:course_title}</dd>
<dt>Veranstaltung</dt> <dd>{VAR:event_title} am {VAR:event_date_fmt}</dd>
</dl>

