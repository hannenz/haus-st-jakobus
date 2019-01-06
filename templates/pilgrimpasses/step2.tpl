
{IF({ISSET:saveFailed:VAR})}
	<p class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</p>
{ENDIF}

<form id="pilgrimpass-form" action="" method="post" novalidate>

	<fieldset class="fieldset">
		<legend>Lieferadresse</legend>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-2">
				<div class="form-field form-field--select">
					<label for="pilgrimpass_delivery_address_salutation">Anrede</label>
					<select id="pilgrimpass_delivery_address_salutation" name="pilgrimpass_delivery_address_salutation">
						<option value="Herr" {IF("{VAR:pilgrimpass_delivery_address_salutation}" == "Herr")}selected{ENDIF}>Herr</option>
						<option value="Frau" {IF("{VAR:pilgrimpass_delivery_address_salutation}" == "Frau")}selected{ENDIF}>Frau</option>
					</select>
				</div>
			</div>
			<div class="cell medium-5">
				<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_delivery_address_firstname})}error{ENDIF}">
					<label for="pilgrimpass_firstname">Vorname</label>
					<input type="text" value="{VAR:pilgrimpass_delivery_address_firstname}" name="pilgrimpass_delivery_address_firstname" id="pilgrimpass_delivery_address_firstname" required />
				</div>
			</div>
			<div class="cell medium-5">
				<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_delivery_address_lastname})}error{ENDIF}">
					<label for="pilgrimpass_delivery_address_lastname">Nachname</label>
					<input type="text" value="{VAR:pilgrimpass_delivery_address_lastname}" name="pilgrimpass_delivery_address_lastname" id="pilgrimpass_delivery_address_lastname" required />
				</div>
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell">
				<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_delivery_address_street})}error{ENDIF}">
					<label for="pilgrimpass_delivery_address_street">Anschrift</label>
					<input type="text" value="{VAR:pilgrimpass_delivery_address_street}" name="pilgrimpass_delivery_address_street" id="pilgrimpass_delivery_address_street" required />
				</div>
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell small-3">
				<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_delivery_address_zip})}error{ENDIF}">
					<label for="pilgrimpass_delivery_address_zip">PLZ</label>
					<input type="text" value="{VAR:pilgrimpass_delivery_address_zip}" name="pilgrimpass_delivery_address_zip" id="pilgrimpass_delivery_address_zip" required pattern="[0-9]{5}" />
				</div>
			</div>
			<div class="cell small-9">
				<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_delivery_address_city})}error{ENDIF}">
					<label for="pilgrimpass_delivery_address_city">Stadt</label>
					<input type="text" value="{VAR:pilgrimpass_delivery_address_city}" name="pilgrimpass_delivery_address_city" id="pilgrimpass_delivery_address_city" required />
				</div>
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_delivery_address_country})}error{ENDIF}">
					<label for="pilgrimpass_delivery_address_country">Land</label>
					<input type="text" value="{VAR:pilgrimpass_delivery_address_country}" name="pilgrimpass_delivery_address_country" id="pilgrimpass_delivery_address_country" />
				</div>
			</div>
			<div class="cell medium-6">
				<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_delivery_address_email})}error{ENDIF}">
					<label for="pilgrimpass_delivery_address_email">E-Mail</label>
					<input type="email" value="{VAR:pilgrimpass_delivery_address_email}" name="pilgrimpass_delivery_address_email" id="pilgrimpass_delivery_address_email" />
				</div>
			</div>
		</div>
	</fieldset>

	<div class="action-area"> 
		<input type="hidden" name="step" value="2" />
		<button class="button" name="action" value="back">Zurück</button>
		<button type="submit" class="button" name="action" value="step2">Weiter</button>
	</div>
</form>



