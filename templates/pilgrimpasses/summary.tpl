{IF({ISSET:saveFailed})}
	<p class="error message message--error">Beim Speichern Ihrer Daten ist ein Fehler aufgetreten. Bitte versuchen Sie es noch einmal oder wenden Sie sich per E-Mail an <a href="mailto:info@haus-st-jakobus.de">info@haus-st-jakobus.de</a></p>
{ENDIF}
{IF({ISSET:data-privacy-statement-not-accepted})}
	<p class="error message message--error">Sie müssen unserer Datenschutzerklärung zustimmen, damit wir Ihre Bestellung verarbeiten können.</p>
{ENDIF}

<h2 class="headline">Zusammenfassung Ihrer Bestellung</h2>

<form id="pilgrimpass-form" class="pilgrimpasses-form--summary" action="" method="post">

	<p>Bitte prüfen Sie noch einmal, ob alle Eingaben korrekt sind bevor Sie den Bestellvorgang verbindlich abschliessen.</p>

	<fieldset class="fieldset pilgrimpasses">
		<legend>Pilgerausweise</legend>
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
						<tr><th>Motivation</th> <td>{VAR:pilgrimpass_motivation:ucwords}</td></tr>
						<tr><th>Fortbewegungsmittel</th> <td>{SWITCH("{VAR:pilgrimpass_transportation}")}{CASE("zu-fuss")}Zu Fuß{BREAK}{CASE("mit-dem-fahrrad")}Mit dem Fahrrad{BREAK}{CASE()}Anderes{BREAK}{ENDSWITCH}</td></tr>
					</table>
				</li>
			{ENDLOOP VAR}
		</ol>
	</fieldset>
	<fieldset class="fieldset">
		<legend>Lieferadresse</legend>
		<p>
			<table>
				<tr>
					<th>Name</th>
					<td>
						{VAR:order_delivery_address_salutation} {VAR:order_delivery_address_firstname} {VAR:order_delivery_address_lastname}
					</td>
				</tr>
				<tr>
					<th>Anschrift</th>
					<td>
						{VAR:order_delivery_address_street}<br>
						{VAR:order_delivery_address_zip} {VAR:order_delivery_address_city}<br>
						{VAR:order_delivery_address_country}<br>
					</td>
				</tr>
				<tr>
					<th>E-Mail</th>
					<td>{VAR:order_delivery_address_email}</td>
				</tr>
			</table>
		</p>
	</fieldset>
	<fieldset class="fieldset">
		<legend>Ihre Spende</legend>
			<table>
				
				<tr>
					<th>Betrag</th>
					<td>{PRINTF:{VAR:order_amount}:"%.2f":en_US.utf8} &euro;</td>
				</tr>
				<tr>
					<th>Zahlungsart</th>
					<td>
						{SWITCH("{VAR:order_payment_method}")}
							{CASE("giropay")}Giropay{BREAK}
							{CASE("ueberweisung")}Überweisung{BREAK}
							{CASE("bargeld")}Bargeld{BREAK}
						{ENDSWITCH}
					</td>
				</tr>
				<!-- <tr> -->
				<!-- 	<th>Express</th> -->
				<!-- 	<td>{IF({ISSET:order_express})}Ja{ELSE}Nein{ENDIF}</td> -->
				<!-- </tr> -->
			</table>
	</fieldset>

	{IF({ISSET:order_message})}
		<fieldset class="fieldset">
			<legend>Nachricht / Bemerkung</legend>
			<p>{VAR:order_message:nl2br}</p>
		</fieldset>
	{ENDIF}

	<fieldset class="fieldset">
		<legend>Datenschutz</legend>
		<div class="form-field form-field--flag">
			<input type="checkbox" name="data-privacy-statement-accepted" id="data-privacy-statement-accepted" />
			<label for="data-privacy-statement-accepted">Ich habe die <a href="{PAGEURL:58}" target="_blank">Datenschutzerkluarung</a> gelesen und erkläre mich hiermit einverstanden</label>
		</div>

	</fieldset>

	<input type="hidden" name="step" value="summary">
	<div class="action-area">
		<button class="button" name="action" value="complete" type="submit">Verbindlich bestellen</button>
		<button class="button" name="action" value="back">Zurück</button>
		<a href="{PAGEURL}?action=abort" onclick="return confirm('Sind Sie sicher, dass Sie den Bestellvorgang abbrechen möchten?');">Abbrechen</a>
	</div>
</form>
