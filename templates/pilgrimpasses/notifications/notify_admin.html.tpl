{IF("{VAR:passes_count}" == "1")}
<p>Ein Pilgerausweis wurde beantragt mit folgenden Daten:</p>
{ELSE}
<p>Es wurden {VAR:passes_count} Pilgerausweise beantragt mit folgenden Daten:</p>
{ENDIF}

<h3>1. Pilgerausweise</h3>

<ol>
{LOOP VAR(pilgrimpasses)}
	<li>
	<table>
		<tr>
			<td>Anrede</td>
			<td>{VAR:pilgrimpass_salutation}</td>
		</tr>
		<tr>
			<td>Vorname</td>
			<td>{VAR:pilgrimpass_firstname}</td>
		</tr>
		<tr>
			<td>Nachname</td>
			<td>{VAR:pilgrimpass_lastname}</td>
		</tr>
		<tr>
			<td>Adresse</td>
			<td>{VAR:pilgrimpass_street_address}</td>
		</tr>
		<tr>
			<td>Land</td>
			<td>{VAR:pilgrimpass_country}</td>
		</tr>
		<tr>
			<td>PLZ</td>
			<td>{VAR:pilgrimpass_zip}</td>
		</tr>
		<tr>
			<td>Ort</td>
			<td>{VAR:pilgrimpass_city}</td>
		</tr>
		<tr>
			<td>E-Mail</td>
			<td>{VAR:pilgrimpass_email}</td>
		</tr>
		<tr>
			<td>Pilgerweg</td>
			<td>
				{SWITCH ("{VAR:pilgrimpass_route}")}
					{CASE ("camino-de-santiago")}Camino de Santiago{BREAK}
					{CASE ("via-francigena")}Via Francigena{BREAK}
					{CASE ()}[{VAR:pilgrimpass_route}]{BREAK}
				{ENDSWITCH}
			</td>
		</tr>
		<tr>
			<td>Startdatum</td>
			<td>{VAR:pilgrimpass_start_date}</td>
		</tr>
		<tr>
			<td>Start (Ort)</td>
			<td>{VAR:pilgrimpass_start_location}</td>
		</tr>
		<tr>
			<td>Motivation</td>
			<td>
				{SWITCH("{VAR:pilgrimpass_motivation}")}
					{CASE("religiös")}religiös{BREAK}
					{CASE("religiös-kulturell")}religiös/kulturell{BREAK}
					{CASE("kulturell-sportlich")}kulturell/sportlich{BREAK}
					{CASE("religiös-sportlich")}religiös/sportlich{BREAK}
				{ENDSWITCH}
			</td>
		</tr>
		<tr>
			<td>Fortbewegungsmittel</td>
			<td>
				{SWITCH("{VAR:pilgrimpass_transportation}")}
					{CASE("zu-fuss")}Zu Fuß{BREAK}
					{CASE("mit-dem-fahrrad")}Mit dem Fahrrad{BREAK}
					{CASE("auf-dem-pferd")}Auf dem Pferd{BREAK}
				{ENDSWITCH}
			</td>
		</tr>
	</table>
	</li>
{ENDLOOP VAR}
</ol>

<h3>2. Lieferadresse</h3>

<table>
	<tr>
		<td>Anrede</td>
		<td>{VAR:order_delivery_address_salutation}</td>
	</tr>
	<tr>
		<td>Vorname</td>
		<td>{VAR:order_delivery_address_firstname}</td>
	</tr>
	<tr>
		<td>Nachname</td>
		<td>{VAR:order_delivery_address_lastname}</td>
	</tr>
	<tr>
		<td>Anschrift</td>
		<td>{VAR:order_delivery_address_street}</td>
	</tr>
	<tr>
		<td>PLZ</td>
		<td>{VAR:order_delivery_address_zip}</td>
	</tr>
	<tr>
		<td>Ort</td>
		<td>{VAR:order_delivery_address_city}</td>
	</tr>
	<tr>
		<td>Land</td>
		<td>{VAR:order_delivery_address_country}</td>
	</tr>
	<tr>
		<td>E-Mail</td>
		<td>{VAR:order_delivery_address_email}</td>
	</tr>
</table>


<h3>3. Bezahlung</h3>

<table>
	<tr>
		<td>Zahlungsmethode</td>
		<td>
			{SWITCH("{VAR:order_payment_method}")}
				{CASE("paypal")}PayPal{BREAK}
				{CASE("giropay")}GiroPay{BREAK}
				{CASE("ueberweisung")}Überweisung{BREAK}
				{CASE("bargeld")}Bargeld{BREAK}
			{ENDSWITCH}
		</td>
	</tr>
	<tr>
		<td>Betrag</td>
		<td>{VAR:order_amount} &euro;</td>
	</tr>
</table>

{IF({ISSET:order_message})}
<h3>4. Nachricht / Bemerkung</h3>
<p>{VAR:order_message:nl2br}</p>
{ENDIF}
