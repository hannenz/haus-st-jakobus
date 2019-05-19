<style type="text/css">
.jakobusPilgrimpasses {
	display: flex;
	flex-wrap: wrap;
	margin: 0 -10px;
}

.jakobusPilgrimpass {
	margin: 3rem 0;
	border: 1px dashed #e0e0e0;
	padding: 10px;
	width: 400px;
	max-width: 400px;
	margin: 10px;
}

.jakobusPilgrimpass table {
	width: 100%;
}

.jakobusPilgrimpasses td {
	padding: 4px 10px;
}

.jakobusPilgrimpass tr {
	background-color: #f0f0f0;
}
.jakobusPilgrimpass tr:nth-child(even) {
	background-color: #ffffff;
}
.jakobusPilgrimpass td:nth-child(1) {
	color: #606060;
}
</style>

<div class="jakobusPilgrimpasses">
	{LOOP VAR(passes)}
		<div class="jakobusPilgrimpass">
			<table>
				<tr>
					<td>Ausweis-Nr</td>
					<td>{VAR:pilgrimpass_pass_nr}</td>
				</tr>
				<tr>
					<td>Anrede</td>
					<td>{VAR:pilgrimpass_salutation}</td>
				</tr>
				<tr>
					<td>Vorname</td>
					<td>
						<!-- <input type="text" value="{VAR:pilgrimpass_firstname}" readonly /> -->
						{VAR:pilgrimpass_firstname}
					</td>
				</tr>
				<tr>
					<td>Nachname</td>
					<td>{VAR:pilgrimpass_lastname}</td>
				</tr>
				<tr>
					<td>Anschrift</td>
					<td>{VAR:pilgrimpass_street_address}</td>
				</tr>
				<tr>
					<td>PLZ</td>
					<td>{VAR:pilgrimpass_zip}</td>
				</tr>
				<tr>
					<td>Ort</td>
					<td>{VAR:pilgrimpass_city}</td>
				</tr>
				<tr>
					<td>Land</td>
					<td>{VAR:pilgrimpass_country}</td>
				</tr>
				<tr>
					<td>Telefon</td>
					<td>{VAR:pilgrimpass_phone}</td>
				</tr>
				<tr>
					<td>E-Mail</td>
					<td>{VAR:pilgrimpass_email}</td>
				</tr>
				<tr>
					<td>Pilgerweg</td>
					<td>{VAR:pilgrimpass_route}</td>
				</tr>
				<tr>
					<td>Start-Datum</td>
					<td>{DATEFMT:"{VAR:pilgrimpass_start_date}":"%d.%m.%Y"}</td>
				</tr>
				<tr>
					<td>Start-Ort</td>
					<td>{VAR:pilgrimpass_start_location}</td>
				</tr>
				<tr>
					<td>Motivation</td>
					<td>{VAR:pilgrimpass_motivation}</td>
				</tr>
				<tr>
					<td>Fortbewegungsmittl</td>
					<td>{VAR:pilgrimpass_transportation}</td>
				</tr>
			</table>
		</div>
	{ENDLOOP VAR}
</div>
