<h2 class="headline"> Vielen Dank, {VAR:order_delivery_address_salutation} {VAR:order_delivery_address_lastname}</h2>

<p>Ihre Bestellung ist bei uns eingegangen.</p>

{IF({ISSET:payment_error_message})}
<div class="message error message--error">{VAR:payment_error_message}</div>
{ENDIF}

{IF("{VAR:order_amount}" != "0")}
	{SWITCH("{VAR:order_payment_method}")}
		{CASE("paypal")}
			<form action="{PAGEURL}" method="post">
				<input type="hidden" value="pay" name="action" />
				<input type="hidden" value="{VAR:orderId}" name="order_id" />
				<input type="hidden" value="{VAR:order_amount}" name="amount" />
				<input type="hidden" value="paypal" name="transaction_type">
				<div class="formField">
					<p><button class="button" type="submit">Jetzt mit Paypal bezahlen</button></p>
				</div>	
			</form>
		{BREAK}
		{CASE("giropay")}
			<form action="{PAGEURL}" method="post">
				<input type="hidden" value="pay" name="action" />
				<input type="hidden" value="{VAR:orderId}" name="order_id" />
				<input type="hidden" value="{VAR:order_amount}" name="amount" />
				<input type="hidden" value="giropay" name="transaction_type">
				<div class="formField">
					<p><button class="button" type="submit">Jetzt mit Giropay bezahlen</button></p>
				</div>	
			</form>
		{BREAK}
		{CASE("ueberweisung")}
			<p>Bitte überweisen Sie den Betrag von {VAR:order_amount} &euro; auf folgendes Konto:</p>
			<p>
				{VAR:corporate_data_bank_account_name}<br>
				IBAN: {VAR:corporate_data_bank_account_iban}<br>
				BIC: {VAR:corporate_data_bank_account_bic}<br>
				Verwendungszweck: <span>&laquo;Bestellnr {VAR:orderId}&raquo;</span>
			</p>
			<p><button class="button" onclick="window.print()">Diese Seite drucken</button></p>
		{BREAK}
		{CASE("bargeld")}
			<p>Bitte senden Sie den Betrag von {VAR:pilgrimpass_amount} &euro; per Post an diese Adresse</p>
			<p>
				{VAR:corporate_data_address_organization}<br>
				{VAR:corporate_data_address_street_address}<br>
				{VAR:corporate_data_address_country}&ndash;{VAR:corporate_data_address_zip} {VAR:corporate_data_address_city}<br>
			</p>
			<p>
				Bitte vermerken Sie in Ihrem Schreiben die <em>Bestellnr. {VAR:orderId}</em>
			</p>
		{BREAK}
	{ENDSWITCH}
{ENDIF}

