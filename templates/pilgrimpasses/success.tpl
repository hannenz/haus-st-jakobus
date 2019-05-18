<h2 class="headline"> Vielen Dank, {VAR:pilgrimpass_firstname} {VAR:pilgrimpass_lastname}</h2>

Ihre Bestellung ist bei uns eingegangen.

{SWITCH("{VAR:pilgrimpass_payment_method}")}
	{CASE("giropay")}
		<form action="{PAGEURL}" method="post">
			<input type="hidden" value="pay" name="action" />
			<input type="hidden" value="{VAR:pilgrimpassId}" />
			<input type="hidden" value="{VAR:pilgrimpass_amount}" name="amount" />
			<div class="formField">
				<label for="transaction-type">Bezahlart</label>
				<select id="transaction-type" name="transaction_type">
					<option value="giropay">giropay</option>
					<option value="paypal">PayPal</option>
					<option value="sofortuw">Sofortüberweisung</option>
				</select>
			</div>
			<div class="formField">
				<p><button class="button" type="submit">Jetzt bezahlen</button></p>
			</div>	
		</form>
	{BREAK}
	{CASE("ueberweisung")}
		<p>Bitte überweisen Sie den Betrag von {VAR:pilgrimpass_amount} &euro; auf folgendes Konto:</p>
		<p>
			{VAR:corporate_data_bank_account_name}<br>
			IBAN: {VAR:corporate_data_bank_account_iban}<br>
			BIC: {VAR:corporate_data_bank_account_bic}<br>
			Verwendungszweck: &laquo;PA-Nr {VAR:pilgrimpass_pass_nr}&rdquo;
		</p>
		<p><button class="button secondary" onclick="window.print()">Diese Seite drucken</button></p>
	{BREAK}
	{CASE("bargeld")}
		<p>Bitte senden Sie den Betrag von {VAR:pilgrimpass_amount} &euro; per Post an diese Adresse</p>
		<p>
			{VAR:corporate_data_address_organization}<br>
			{VAR:corporate_data_address_street_address}<br>
			{VAR:corporate_data_address_country}&ndash;{VAR:corporate_data_address_zip} {VAR:corporate_data_address_city}<br>
		</p>
	{BREAK}
{ENDSWITCH}

<p>Sie werden per E-Mail an <em>&lt;{VAR:pilgrimpass_delivery_address_email}&gt;</em> informiert, sobald der/die Pilgerausweis/e versendet werden</p>

