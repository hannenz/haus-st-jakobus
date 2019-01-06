<h2 class="headline"> Vielen Dank, {VAR:pilgrimpass_firstname} {VAR:pilgrimpass_lastname}</h2>

Ihre Bestellung ist bei uns eingegangen.

{SWITCH("{VAR:pilgrimpass_payment_method}")}
	{CASE("giropay")}
		TODO: implement giropay
	{BREAK}
	{CASE("ueberweisung")}
		<p>Bitte überweisen Sie den Betrag von {VAR:pilgrimpass_amount} &euro; auf folgendes Konto:</p>
		<p>
			Hier Kontodaten<br>
			einfügen!<br>
			Sparkasse Ulm<br>
			Verwendungszweck: XXXX XXXX
		</p>
	{BREAK}
	{CASE("bargeld")}
		<p>Bitte senden Sie den Betrag von {VAR:pilgrimpass_amount} &euro; per Post an diese Adresse</p>
		<p>
			Haus St. Jakobus<br>

			89XXX Oberdischingen
		</p>
	{BREAK}
{ENDSWITCH}

<p>Sie werden per E-Mail an &lt;{VAR:pilgrimpass_delivery_address_email}&gt; informiert, sobald der/die Pilgerausweis/e versendet werden</p>
