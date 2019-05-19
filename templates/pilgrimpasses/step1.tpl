{IF({ISSET:saveFailed:VAR})}
	<p class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</p>
{ENDIF}

<h2 class="headline">Pilgerausweise bestellen</h2>

<form id="pilgrimpass-form" action="" method="post" novalidate>
	<div id="form-container">
		{LOOP VAR(pilgrimpasses)}
			<fieldset class="fieldset">
				<legend>Persönliche Angaben</legend>
				<a class="remove-button">
					<span>Diesen Pilgerpass entfernen</span> 
					<svg class="icon" width="100" height="100" viewBox="0 0 100 100"> <path d="M 67.67767,18.180195 50,35.857864 32.32233,18.180195 18.180195,32.32233 35.857864,50 18.180195,67.67767 32.32233,81.819805 50,64.142136 67.67767,81.819805 81.819805,67.67767 64.142136,50 81.819805,32.32233 Z"> </svg>
				</a>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-2">
						<div class="form-field form-field--select">
							<label for="pilgrimpass_salutation-1">Anrede</label>
							<select id="pilgrimpass_salutation-1" name="pilgrimpass_salutation[]">
								<option value="Herr" {IF("{VAR:pilgrimpass_salutation}" == "Herr")}selected{ENDIF}>Herr</option>
								<option value="Frau" {IF("{VAR:pilgrimpass_salutation}" == "Frau")}selected{ENDIF}>Frau</option>
							</select>
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_firstname})}error{ENDIF}">
							<label for="pilgrimpass_firstname-1">Vorname</label>
							<input type="text" value="{VAR:pilgrimpass_firstname}" name="pilgrimpass_firstname[]" id="pilgrimpass_firstname-1" required />
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_lastname})}error{ENDIF}">
							<label for="pilgrimpass_lastname-1">Nachname</label>
							<input type="text" value="{VAR:pilgrimpass_lastname}" name="pilgrimpass_lastname[]" id="pilgrimpass_lastname-1" required />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_street_address})}error{ENDIF}">
							<label for="pilgrimpass_street_address-1">Anschrift</label>
							<input type="text" value="{VAR:pilgrimpass_street_address}" name="pilgrimpass_street_address[]" id="pilgrimpass_street_address-1" required />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell small-2">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_zip})}error{ENDIF}">
							<label for="pilgrimpass_zip-1">PLZ</label>
							<input type="text" value="{VAR:pilgrimpass_zip}" name="pilgrimpass_zip[]" id="pilgrimpass_zip-1" required />
						</div>
					</div>
					<div class="cell small-5">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_city})}error{ENDIF}">
							<label for="pilgrimpass_city-1">Stadt</label>
							<input type="text" value="{VAR:pilgrimpass_city}" name="pilgrimpass_city[]" id="pilgrimpass_city-1" />
						</div>
					</div>
				<!-- </div> -->
                <!--  -->
				<!-- <div class="grid&#45;x grid&#45;padding&#45;x"> -->
					<div class="cell medium-5">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_country})}error{ENDIF}">
							<label for="pilgrimpass_country-1">Land</label>
							<input type="text" value="{VAR:pilgrimpass_country}" name="pilgrimpass_country[]" id="pilgrimpass_country-1" required />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-6">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_phone})}error{ENDIF}">
							<label for="pilgrimpass_phone-1">Telefon</label>
							<input type="text" value="{VAR:pilgrimpass_phone}" name="pilgrimpass_phone[]" id="pilgrimpass_phone-1" />
						</div>
					</div>
					<div class="cell medium-6">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_email})}error{ENDIF}">
							<label for="pilgrimpass_email-1">E-Mail</label>
							<input type="text" value="{VAR:pilgrimpass_email}" name="pilgrimpass_email[]" id="pilgrimpass_email-1" required />
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
							<label for="pilgrimpass_route-1">Pilgerweg</label>
							<select name="pilgrimpass_route[]" id="pilgrimpass_route-1">
								<option value="camino-de-santiago" {IF("{VAR:pilgrimpass_route}" == "camino-de-santiago")}selected{ENDIF}>Camino de Santiago</option>
								<option value="via-francigena" {IF("{VAR:pilgrimpass_route}" == "via-francigena")}selected{ENDIF}>Via Francigena</option>
							</select>
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--date {IF({ISSET:error_pilgrimpass_start_date})}error{ENDIF}">
							<label>Startdatum (mind. 5 Tage in der Zukunft)</label>
							<input type="date" min="{VAR:startDateMin}" value="{VAR:pilgrimpass_start_date}" name="pilgrimpass_start_date[]" id="pilgrimpass_start_date" />
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_start_location})}error{ENDIF}">
							<label for="pilgrimpass_start_location-1">Start (Ort)</label>
							<input type="text" value="{VAR:pilgrimpass_start_location}" name="pilgrimpass_start_location[]" id="pilgrimpass_start_location-1" />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-4">
						<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_motivation})}error{ENDIF}">
							<label for="pilgrimpass_motivation-1">Motivation</label>
							<select name="pilgrimpass_motivation[]" id="pilgrimpass_motivation-1">
								<option value="religiös" {IF("{VAR:pilgrimpass_motivation}" == "religiös")}selected{ENDIF}>religiös</option>
								<option value="religiös-kulturell" {IF("{VAR:pilgrimpass_motivation}" == "religiös-kulturell")}selected{ENDIF}>religiös-kulturell</option>
								<option value="kulturell-sportlich" {IF("{VAR:pilgrimpass_motivation}" == "kulturell-sportlich")}selected{ENDIF}>kulturell-sportlich</option>
								<option value="religiös-sportlich" {IF("{VAR:pilgrimpass_motivation}" == "religiös-sportlich")}selected{ENDIF}>religiös-sportlich</option>
							</select>
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_transportation})}error{ENDIF}">
							<label for="pilgrimpass_transportation-1">Fortbewegungsmittel</label>
							<select name="pilgrimpass_transportation[]" id="pilgrimpass_transportation-1">
								<option value="zu-fuss" {IF("{VAR:pilgrimpass_transportation}" == "zu-fuss")}selected{ENDIF}>Zu Fuß</option>
								<option value="mit-dem-fahrrad" {IF("{VAR:pilgrimpass_transportation}" == "mit-dem-fahrrad")}selected{ENDIF}>Mit dem Fahrrad</option>
								<option value="auf-dem-pferd" {IF("{VAR:pilgrimpass_transportation}" == "auf-dem-pferd")}selected{ENDIF}>Auf dem Pferd</option>
							</select>
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell">
						<div class="info">
							Die mit einem <span>*</span> gekennzeichneten Felder müssen ausgefüllt werden.
						</div>
					</div>
				</div>
			</fieldset>
		{ENDLOOP VAR}
	</div>


	<input type="hidden" value="{VAR:count}" name="count" id="count" />
	<input type="hidden" name="step" value="1" />
	<div class="action-area"> 
		<button type="submit" class="button" name="action" value="step1">Weiter</button>
		<button class="button" id="add-button">
			<svg class="icon" width="100" height="100" viewBox="0 0 100 100">
				<path d="M 40,15 V 40 H 15 V 60 H 40 V 85 H 60 V 60 H 85 V 40 H 60 V 15 Z" />
			</svg>
			<span>Pilgerpass hinzufügen</span>
		</button>
	</div>
</form>


