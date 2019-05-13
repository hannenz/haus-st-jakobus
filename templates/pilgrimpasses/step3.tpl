{IF({ISSET:saveFailed:VAR})}
	<p class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</p>
{ENDIF}

<form id="pilgrimpass-form" action="" method="post">
	<fieldset class="fieldset">
		<legend>Bezahlung</legend>
		<div class="form-field form-field--payment">

			<p>Sie haben {VAR:pilgrimpassesCount} Pilgerausweise bestellt. Wie viel möchten Sie bezahlen?</p>

			<div class="button-group">
				<input id="payment-amount-1" type="radio" name="pilgrimpass_amount" value="{VAR:amount1}">
				<label for="payment-amount-1" class="button">{VAR:amount1} &euro;</label>

				<input id="payment-amount-2" type="radio" name="pilgrimpass_amount" value="{VAR:amount2}">
				<label for="payment-amount-2" class="button">{VAR:amount2} &euro;</label>

				<input id="payment-amount-3" type="radio" name="pilgrimpass_amount" value="{VAR:amount3}">
				<label for="payment-amount-3" class="button">{VAR:amount3} &euro;</label>

				<input id="payment-amount-custom" type="radio" name="pilgrimpass_amount" value="custom">
				<label for="payment-amount-custom" class="button">Anderer Betrag</label>

				<input type="text" id="payment-amount-custom-text" name="pilgrimpass_amount_custom" value="" placeholder="Geben Sie einen beliebigen Euro-Betrag ein">
				<label for="payment-amount-custom-text">&euro;</label>
			</div>
		</div>

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
		<!-- <div class="form&#45;field form&#45;field&#45;&#45;text {IF({ISSET:error_pilgrimpass_amount})}error{ENDIF}"> -->
		<!-- 	<label for="pilgrimpass_amount">Betrag</label> -->
		<!-- 	<input type="text" value="{VAR:pilgrimpass_amount}" name="pilgrimpass_amount" id="pilgrimpass_amount" /> -->
		<!-- </div> -->
		<!-- <div class="form&#45;field form&#45;field&#45;&#45;text {IF({ISSET:error_pilgrimpass_blz})}error{ENDIF}"> -->
		<!-- 	<label for="pilgrimpass_blz">BLZ</label> -->
		<!-- 	<input type="text" value="{VAR:pilgrimpass_blz}" name="pilgrimpass_blz" id="pilgrimpass_blz" /> -->
		<!-- </div> -->
		<div class="form-field form-field--text-area">
			<label for="pilgrimpass_message">Mitteilung</label>
			<textarea name="pilgrimpass_message" id="pilgrimpass_message" rows="10" placeholder="Hier haben Sie noch die Möglichkeit, uns eine Nachricht zukommen zu lassen">{VAR:pilgrimpass_message}</textarea>
			<div class="info"></div>
		</div>
	</fieldset>

	<input type="hidden" name="step" value="3" />
	<div class="action-area"> 
		<button class="button" type="submit" name="action" value="step3">Weiter</button>
		<button class="button" name="action" value="back">Zurück</button>
	</div>
</form>

