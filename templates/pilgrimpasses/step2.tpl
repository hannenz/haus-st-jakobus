
{IF({ISSET:saveFailed:VAR})}
	<p class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</p>
{ENDIF}

<h2 class="headline">Pilgerausweise bestellen</h2>

<form id="pilgrimpass-form" action="" method="post" novalidate>

	<fieldset class="fieldset">
		<legend>Lieferadresse</legend>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-2">
				<div class="form-field form-field--select">
					<label for="order_delivery_address_salutation">Anrede</label>
					<select id="order_delivery_address_salutation" name="order_delivery_address_salutation">
						<option value="Herr" {IF("{VAR:order_delivery_address_salutation}" == "Herr")}selected{ENDIF}>Herr</option>
						<option value="Frau" {IF("{VAR:order_delivery_address_salutation}" == "Frau")}selected{ENDIF}>Frau</option>
					</select>
				</div>
			</div>
			<div class="cell medium-5">
				<div class="form-field form-field--text {IF({ISSET:error_order_delivery_address_firstname})}error{ENDIF}">
					<label for="order_firstname">Vorname</label>
					<input type="text" value="{VAR:order_delivery_address_firstname}" name="order_delivery_address_firstname" id="order_delivery_address_firstname" required />
				</div>
			</div>
			<div class="cell medium-5">
				<div class="form-field form-field--text {IF({ISSET:error_order_delivery_address_lastname})}error{ENDIF}">
					<label for="order_delivery_address_lastname">Nachname</label>
					<input type="text" value="{VAR:order_delivery_address_lastname}" name="order_delivery_address_lastname" id="order_delivery_address_lastname" required />
				</div>
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell">
				<div class="form-field form-field--text {IF({ISSET:error_order_delivery_address_street})}error{ENDIF}">
					<label for="order_delivery_address_street">Anschrift</label>
					<input type="text" value="{VAR:order_delivery_address_street}" name="order_delivery_address_street" id="order_delivery_address_street" required />
				</div>
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell small-3">
				<div class="form-field form-field--text {IF({ISSET:error_order_delivery_address_zip})}error{ENDIF}">
					<label for="order_delivery_address_zip">PLZ</label>
					<input type="text" value="{VAR:order_delivery_address_zip}" name="order_delivery_address_zip" id="order_delivery_address_zip" required pattern="[0-9]{5}" />
				</div>
			</div>
			<div class="cell small-9">
				<div class="form-field form-field--text {IF({ISSET:error_order_delivery_address_city})}error{ENDIF}">
					<label for="order_delivery_address_city">Stadt</label>
					<input type="text" value="{VAR:order_delivery_address_city}" name="order_delivery_address_city" id="order_delivery_address_city" required />
				</div>
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				<div class="form-field form-field--text {IF({ISSET:error_order_delivery_address_country})}error{ENDIF}">
					<label for="order_delivery_address_country">Land</label>
					<input type="text" value="{VAR:order_delivery_address_country}" name="order_delivery_address_country" id="order_delivery_address_country" />
				</div>
			</div>
			<div class="cell medium-6">
				<div class="form-field form-field--text {IF({ISSET:error_order_delivery_address_email})}error{ENDIF}">
					<label for="order_delivery_address_email">E-Mail</label>
					<input type="email" value="{VAR:order_delivery_address_email}" name="order_delivery_address_email" id="order_delivery_address_email" />
				</div>
			</div>
		</div>
	</fieldset>

	<input type="hidden" name="step" value="2" />
	<div class="action-area"> 
		<button type="submit" class="button" name="action" value="step2">Weiter</button>
		<button class="button" name="action" value="back">Zurück</button>
		<a class="pilgrimpass-abort" data-confirm-text="Sind Sie sicher, dass Sie die Bestellung abbrechen möchten?" href="{PAGEURL}?action=abort">Abbrechen</a>
	</div>
</form>



