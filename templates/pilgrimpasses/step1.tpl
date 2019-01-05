
{IF({ISSET:saveFailed:VAR})}
	<div class="error">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</div>
{ENDIF}

<form id="pilgrimpass-form" action="" method="post" novalidate>


	<div id="form-container">
		{LOOP VAR(pilgrimpasses)}
			<fieldset class="fieldset">
				<legend>Persönliche Angaben</legend>
				<button class="button remove-button">Diesen Pilgerpass entfernen</button>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-2">
						<div class="form-field form-field--select">
							<label for="pilgrimpass_salutation">Anrede</label>
							<select id="pilgrimpass_salutation" name="pilgrimpass_salutation[]">
								<option value="Herr">Herr</option>
								<option value="Frau">Frau</option>
							</select>
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_firstname})}error{ENDIF}">
							<label for="pilgrimpass_firstname">Vorname</label>
							<input type="text" value="{VAR:pilgrimpass_firstname}" name="pilgrimpass_firstname[]" id="pilgrimpass_firstname" required />
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_lastname})}error{ENDIF}">
							<label for="pilgrimpass_lastname">Nachname</label>
							<input type="text" value="{VAR:pilgrimpass_lastname}" name="pilgrimpass_lastname[]" id="pilgrimpass_lastname" required />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_street_address})}error{ENDIF}">
							<label for="pilgrimpass_street_address">Anschrift</label>
							<input type="text" value="{VAR:pilgrimpass_street_address}" name="pilgrimpass_street_address[]" id="pilgrimpass_street_address" />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell small-3">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_zip})}error{ENDIF}">
							<label for="pilgrimpass_zip">PLZ</label>
							<input type="text" value="{VAR:pilgrimpass_zip}" name="pilgrimpass_zip[]" id="pilgrimpass_zip" />
						</div>
					</div>
					<div class="cell small-9">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_city})}error{ENDIF}">
							<label for="pilgrimpass_city">Stadt</label>
							<input type="text" value="{VAR:pilgrimpass_city}" name="pilgrimpass_city[]" id="pilgrimpass_city" />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-6">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_country})}error{ENDIF}">
							<label for="pilgrimpass_country">Land</label>
							<input type="text" value="{VAR:pilgrimpass_country}" name="pilgrimpass_country[]" id="pilgrimpass_country" />
						</div>
					</div>
					<div class="cell medium-6">
						<div class="form-field form-field--date {IF({ISSET:error_pilgrimpass_birthday})}error{ENDIF}">
							<label for="pilgrimpass_birthday">Geburtstag</label>
							<input type="date" value="{VAR:pilgrimpass_birthday}" name="pilgrimpass_birthday[]" id="pilgrimpass_birthday" />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-6">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_phone})}error{ENDIF}">
							<label for="pilgrimpass_phone">Telefon</label>
							<input type="text" value="{VAR:pilgrimpass_phone}" name="pilgrimpass_phone[]" id="pilgrimpass_phone" />
						</div>
					</div>
					<div class="cell medium-6">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_email})}error{ENDIF}">
							<label for="pilgrimpass_email">E-Mail</label>
							<input type="text" value="{VAR:pilgrimpass_email}" name="pilgrimpass_email[]" id="pilgrimpass_email" />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_idnr})}error{ENDIF}">
							<label for="pilgrimpass_idnr">Personalausweis-Nr.</label>
							<input type="text" value="{VAR:pilgrimpass_idnr}" name="pilgrimpass_idnr[]" id="pilgrimpass_idnr" />
						</div>
					</div>
				</div>
			<!-- </fieldset> -->
            <!--  -->
            <!--  -->
			<!-- <fieldset class="fieldset"> -->
				<!-- <legend>Pilgerweg</legend> -->

				<div class="grid-x grid-padding-x">
					<div class="cell medium-4">
						<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_route})}error{ENDIF}">
							<label for="pilgrimpass_route">Pilgerweg</label>
							<select name="pilgrimpass_route[]" id="pilgrimpass_route">
								<option value="camino-de-santiago">Camino de Santiago</option>
								<option value="via-francigena">Via Francigena</option>
							</select>
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--date {IF({ISSET:error_pilgrimpass_start_date})}error{ENDIF}">
							<label>Startdatum</label>
							<input type="date" value="{VAR:pilgrimpass_start_date}" name="pilgrimpass_start_date[]" id="pilgrimpass_start_date" />
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_start_location})}error{ENDIF}">
							<label for="pilgrimpass_start_location">Start (Ort)</label>
							<input type="text" value="{VAR:pilgrimpass_start_location}" name="pilgrimpass_start_location[]" id="pilgrimpass_start_location" />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-4">
						<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_motivation})}error{ENDIF}">
							<label for="pilgrimpass_motivation">Motivation</label>
							<select name="pilgrimpass_motivation[]" id="pilgrimpass_motivation">
								<option value="religiös">religiös</option>
								<option value="religiös-kulturell">religiös-kulturell</option>
								<option value="kulturell-sportlich">kulturell-sportlich</option>
								<option value="religiös-sportlich">religiös-sportlich</option>
							</select>
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_transportation})}error{ENDIF}">
							<label for="pilgrimpass_transportation">Fortbewegungsmittel</label>
							<select name="pilgrimpass_transportation[]" id="pilgrimpass_transportation">
								<option value="zu-fuss">Zu Fuß</option>
								<option value="mit-dem-fahrrad">Mit dem Fahrrad</option>
								<option value="auf-dem-pferd">Auf dem Pferd</option>
							</select>
						</div>
					</div>
				</div>
			</fieldset>
		{ENDLOOP VAR}
	</div>

	<input type="hidden" name="action" value="step1" />
	<input type="hidden" value="{VAR:count}" name="count" id="count" />
	<div class="action-area"> 
		<button class="button" id="add-button">Pilgerpass hinzufügen</button>
		<button type="submit" class="button">Weiter</button>
	</div>
</form>


