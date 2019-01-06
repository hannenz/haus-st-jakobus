{IF({ISSET:saveFailed:VAR})}
	<p class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</p>
{ENDIF}

<form id="pilgrimpass-form" action="" method="post">
	<fieldset class="fieldset">
		<legend>Bezahlung</legend>
		<div class="form-field form-field--select">
			<label for="pilgrimpass_payment_method">Zahlungsart</label>
			<select name="pilgrimpass_payment_method" id="pilgrimpass_payment_method">
				<option value="giropay" {IF("{VAR:pilgrimpass_payment_method}" == "giropay")}selected{ENDIF}>Giropay</option>
				<option value="ueberweisung" {IF("{VAR:pilgrimpass_payment_method}" == "ueberweisung")}selected{ENDIF}>Überweisung</option>
				<option value="bargeld" {IF("{VAR:pilgrimpass_payment_method}" == "bargeld")}selected{ENDIF}>Bargeld</option>
			</select>
		</div>
		<div class="form-field form-field--checkbox">
			<label for="pilgrimpass_express">Express</label>
			<input type="checkbox" name="pilgrimpass_express" id="pilgrimpass_express" {IF({ISSET:pilgrimpass_express})}checked{ENDIF} />
		</div>
		<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_amount})}error{ENDIF}">
			<label for="pilgrimpass_amount">Betrag</label>
			<input type="text" value="{VAR:pilgrimpass_amount}" name="pilgrimpass_amount" id="pilgrimpass_amount" />
		</div>
		<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_blz})}error{ENDIF}">
			<label for="pilgrimpass_blz">BLZ</label>
			<input type="text" value="{VAR:pilgrimpass_blz}" name="pilgrimpass_blz" id="pilgrimpass_blz" />
		</div>
		<div class="form-field form-field--text-area">
			<label for="pilgrimpass_message">Mitteilung</label>
			<textarea name="pilgrimpass_message" id="pilgrimpass_message">{VAR:pilgrimpass_message}</textarea>
		</div>
	</fieldset>
	<div class="action-area"> 
		<input type="hidden" name="step" value="3" />
		<button class="button" name="action" value="back">Zurück</button>
		<button class="button" type="submit" name="action" value="step3">Weiter</button>
	</div>
</form>

