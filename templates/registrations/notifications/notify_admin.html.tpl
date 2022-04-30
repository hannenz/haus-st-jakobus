<p>Eine Kurs-Anmeldung ist eingegangen mit den folgenden Daten:</p>

<table>
	<tr style="border-top: 1px solid #e0e0e0;">
		<td style="vertical-align: top; padding: 4px">Name</td>
		<td style="vertical-align: top; padding: 4px">{VAR:registration_salutation} {VAR:registration_firstname} {VAR:registration_lastname}</td>
	</tr>
	<tr style="border-top: 1px solid #e0e0e0;">
		<td style="vertical-align: top; padding: 4px">Anschrift</td>
		<td style="vertical-align: top; padding: 4px">
			{VAR:registration_street_address}<br>
			{VAR:registration_zip} {VAR:registration_city}
		</td>
	</tr>
	<tr style="border-top: 1px solid #e0e0e0;">
		<td style="vertical-align: top; padding: 4px">E-Mail</td>
		<td style="vertical-align: top; padding: 4px">{VAR:registration_email}</td>
	</tr>
	<tr style="border-top: 1px solid #e0e0e0;">
		<td style="vertical-align: top; padding: 4px">Mitglied im Förderverein</td>
		<td style="vertical-align: top; padding: 4px">{IF("{VAR:registration_is_member}" == "1")}Ja{ELSE}Nein{ENDIF}</td>
	</tr>
</table>

<table style="margin-top: 64px">
	<tr style="border-top: 1px solid #e0e0e0;">
		<td style="vertical-align: top; padding: 4px">Veranstaltung</td>
		<td style="vertical-align: top; padding: 4px">{VAR:event_title} am {VAR:event_date_fmt}</td>
	</tr>
</table>

