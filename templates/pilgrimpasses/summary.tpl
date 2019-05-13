{IF({ISSET:saveFailed})}
	<p class="error message message--error">Beim Speichern Ihrer Daten ist ein Fehler aufgetreten. Bitte versuchen Sie es noch einmal oder wenden Sie sich per E-Mail an <a href="mailto:info@haus-st-jakobus.de">info@haus-st-jakobus.de</a></p>
{ENDIF}
<form id="pilgrimpass-form" class="pilgrimpasses-form--summary" action="" method="post">
	<h2 class="headline">Zusammenfassung Ihrer Bestellung</h2>

	<p>Bitte prüfen Sie noch einmal, ob alle Eingaben korrekt sind bevor Sie den Bestellvorgang verbindlich abschliessen.</p>

	<div class="pilgrimpasses">
		<h3 class="headline headline--small">Pilgerausweis(e)</h3>
		<ol>
			{LOOP VAR(pilgrimpasses)}
				<li class="card">
					<div>
						<p>
							<strong>{VAR:pilgrimpass_salutation} {VAR:pilgrimpass_firstname} {VAR:pilgrimpass_lastname}</strong><br>
							{VAR:pilgrimpass_street_address}<br>
							{VAR:pilgrimpass_zip} {VAR:pilgrimpass_city}<br>
							{VAR:pilgrimpass_country}<br>
						</p>
						<p>
							Tel: {VAR:pilgrimpass_phone}<br>
							E-Mail: {VAR:pilgrimpass_email}
						</p>
					</div>
					<table>
						<!-- <tr><th>Telefon</th><td>{VAR:pilgrimpass_phone}</td></tr> -->
						<!-- <tr><th>E&#45;Mail</th> <td>{VAR:pilgrimpass_email}</td></tr> -->
						<tr><th>Pilgerweg</th> <td>{SWITCH("{VAR:pilgrimpass_route}")}{CASE("camino-de-santiago")}Camino de Santiago{BREAK}{CASE("via-francigena")}Via Francigena{BREAK}{ENDSWITCH}</td></tr>
						<tr><th>Start-Datum</th> <td>{DATEFMT:{VAR:pilgrimpass_start_date}:%a, %d. %B %Y}</td></tr>
						<tr><th>Start (Ort)</th> <td>{VAR:pilgrimpass_start_location}</td></tr>
						<tr><th>Motivation</th> <td>{VAR:pilgrimpass_motivation}</td></tr>
						<tr><th>Fortbewegungsmittel</th> <td>{SWITCH("{VAR:pilgrimpass_transportation}")}{CASE("zu-fuss")}Zu Fuß{BREAK}{CASE("mit-dem-fahrrad")}Mit dem Fahrrad{BREAK}{CASE("auf-dem-pferd")}Auf dem Pferd{BREAK}{ENDSWITCH}</td></tr>
					</table>
				</li>
			{ENDLOOP VAR}
		</ol>
	</div>
	<div>
		<h3 class="headline headline--small">Lieferadresse</h3>
		<p>
			{VAR:pilgrimpass_delivery_address_salutation} {VAR:pilgrimpass_delivery_address_firstname} {VAR:pilgrimpass_delivery_address_lastname}<br>
			{VAR:pilgrimpass_delivery_address_street}<br>
			{VAR:pilgrimpass_delivery_address_zip} {VAR:pilgrimpass_delivery_address_city}<br>
			{VAR:pilgrimpass_delivery_address_country}<br>
			<table>
				<tr>
					<th>E-Mail</th>
					<td>{VAR:pilgrimpass_delivery_address_email}</td>
				</tr>
			</table>
		</p>
	</div>
	<div>
		<h3 class="headline headline--small">Bezahlung</h3>
		<p>
			<table>
				
				<tr>
					<th>Zahlungsart</th>
					<td>
						{SWITCH("{VAR:pilgrimpass_payment_method}")}
							{CASE("giropay")}Giropay{BREAK}
							{CASE("ueberweisung")}Überweisung{BREAK}
							{CASE("bargeld")}Bargeld{BREAK}
						{ENDSWITCH}
					</td>
				</tr>
				<tr>
					<th>Express</th>
					<td>{IF({ISSET:pilgrimpass_express})}Ja{ELSE}Nein{ENDIF}</td>
				</tr>
				<tr>
					<th>Betrag</th>
					<td>{VAR:pilgrimpass_amount} &euro;</td>
				</tr>
			</table>
		</p>
	</div>
	{IF({ISSET:pilgrimpass_message})}
		<div>
			<h3 class="headline headline--small">Nachricht / Bemerkung</h3>
			<p>{VAR:pilgrimpass_message:nl2br}</p>
		</div>
	{ENDIF}

	<input type="hidden" name="step" value="summary">
	<div class="action-area">
		<button class="button" name="action" value="complete" type="submit">Verbindlich bestellen</button>
		<button class="button" name="action" value="back">Zurück</button>
	</div>
</form>
