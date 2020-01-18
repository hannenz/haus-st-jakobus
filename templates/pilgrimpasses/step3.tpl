{IF({ISSET:saveFailed:VAR})}
	<p class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</p>
{ENDIF}

<h2 class="headline">Pilgerausweise bestellen </h2>

<form id="pilgrimpass-form" name="step3" action="" method="post">
	<fieldset class="fieldset">
		<legend>Ihre Spende</legend>
		<div class="form-field form-field--payment">

			<p>{IF("{VAR:pilgrimpassesCount}" == "1")}Der Pilgerausweis ist{ELSE}Die Pilgerausweise sind{ENDIF} umsonst. Durch <strong>Ihr Spende</strong> unterstützen Sie unsere Arbeit.</p>
			<p>Sie haben {VAR:pilgrimpassesCount} Pilgerausweis{IF("{VAR:pilgrimpassesCount}" != "1")}e{ENDIF} bestellt. Wie viel möchten Sie spenden?<br><small>(Wenn Sie nichts spenden möchten, wählen Sie <em>«Anderer Betrag»</em> und tragen eine <em>«0» (Null)</em> ein)</small></p>
			<div class="button-group">
				<input id="payment-amount-1" type="radio" name="order_amount" value="{VAR:amount1}" {IF("{VAR:order_amount}" == "{VAR:amount1}")}checked{ENDIF}>
				<label for="payment-amount-1" class="button">{VAR:amount1} &euro;</label>

				<input id="payment-amount-2" type="radio" name="order_amount" value="{VAR:amount2}" {IF("{VAR:order_amount}" == "{VAR:amount2}")}checked{ENDIF}>
				<label for="payment-amount-2" class="button">{VAR:amount2} &euro;</label>

				<input id="payment-amount-3" type="radio" name="order_amount" value="{VAR:amount3}" {IF("{VAR:order_amount}" == "{VAR:amount3}")}checked{ENDIF}>
				<label for="payment-amount-3" class="button">{VAR:amount3} &euro;</label>

				<input id="payment-amount-custom" type="radio" name="order_amount" value="custom" {IF({ISSET:order_amount_custom})}checked{ENDIF}>
				<label onclick="javascript:document.getElementById('payment-amount-custom-text').focus()" for="payment-amount-custom" class="button">Anderer Betrag</label>

				<input type="text" id="payment-amount-custom-text" name="order_amount_custom" value="{VAR:order_amount_custom}" placeholder="Beliebigen Euro-Betrag eingeben">
				<label for="payment-amount-custom-text">&euro;</label>
			</div>
			<p>Als Spendenbescheinigung fürs Finanzamt genügt (bis 200 &euro;) der Kontoauszug.<br>
				Spendenbescheinigungen stellen wir ab 50 € aus.<br>
				<a href="{PAGEURL:93}#info-spendenbescheinigung" target="_blank">Weitere Informationen zur Spendenbescheinigung</a>
			</p>
		</div>

		<div id="payment" class="form-field form-field--select">
			<label for="order_payment_method">Bitte Zahlungsart wählen</label>
			<select name="order_payment_method" id="order_payment_method">
				<!-- <option value="paypal" {IF("{VAR:order_payment_method}" == "paypal")}selected{ENDIF}>PayPal</option> -->
				<option value="giropay" {IF("{VAR:order_payment_method}" == "giropay")}selected{ENDIF}>Giropay</option>
				<option value="ueberweisung" {IF("{VAR:order_payment_method}" == "ueberweisung")}selected{ENDIF}>Überweisung</option>
				<option value="bargeld" {IF("{VAR:order_payment_method}" == "bargeld")}selected{ENDIF}>Bargeld</option>
			</select>

			<div hidden id="bank-details">
				<p>
				Falls Sie nicht über Giropay spenden möchten, hier unsere Bankverbindung:<br>
				Kreissparkasse Ulm<br>
				IBAN: DE94 6305 0000 0002 0678 69<br>
				BIC: SOLADES1ULM
				</p>
			</div>
		</div>
		<!-- <div class="form&#45;field form&#45;field&#45;&#45;flag"> -->
		<!-- 	<input type="checkbox" name="order_express" id="order_express" {IF({ISSET:order_express})}checked{ENDIF} /> -->
		<!-- 	<label for="order_express">Express</label> -->
		<!-- </div> -->
	</fieldset>

	<fieldset class="fieldset">
		<legend>Mitteilung</legend>
		<div class="form-field form-field--text-area">
			<label for="order_message">Mitteilung</label>
			<textarea rows="4" name="order_message" id="order_message" rows="10" placeholder="Hier haben Sie noch die Möglichkeit, Ihrer Bestellung eine Bemerkung hinzuzufügen">{VAR:order_message}</textarea>
			<div class="info"></div>
		</div>
	</fieldset>

	<input type="hidden" name="step" value="3" />
	<div class="action-area"> 
		<button class="button" type="submit" name="action" value="step3">Weiter</button>
		<button class="button" name="action" value="back">Zurück</button>
		<a class="pilgrimpass-abort" data-confirm-text="Sind Sie sicher, dass Sie die Bestellung abbrechen möchten?" href="{PAGEURL}?action=abort">Abbrechen</a>
	</div>
</form>

<script>
var select = document.getElementById('order_payment_method');
select.addEventListener('change', onChange);
function onChange() {
	document.getElementById('bank-details').hidden = (select.value != 'ueberweisung');
}
onChange();
</script>
