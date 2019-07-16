Sehr geehrte{IF("{VAR:order_delivery_address_salutation}" == "Herr")}r{ENDIF} {VAR:order_delivery_address_salutation} {VAR:order_delivery_address_lastname},

Hiermit  bestätigen wir Ihnen die Beantragung eines Pilgerausweises mit den folgenden Daten:

-----

1. Pilgerausweise:

{LOOP VAR(pilgrimpasses)}
	{VAR:pilgrimpass_salutation} {VAR:pilgrimpass_firstname} {VAR:pilgrimpass_lastname}
	{VAR:pilgrimpass_street_address}
	{VAR:pilgrimpass_zip} {VAR:pilgrimpass_city}
	{VAR:pilgrimpass_country}

	E-Mail:  {VAR:pilgrimpass_email}

	Route:       {VAR:pilgrimpass_route}
	Start-Datum: {VAR:pilgrimpass_start_date}
	Start (Ort): {VAR:pilgrimpass_start_location}
	
	Motivation:          {VAR:pilgrimpass_motivation}
	Fortbewegungsmittel: {VAR:pilgrimpass_transportation}

	---

{ENDLOOP VAR}

-----

2. Lieferadresse:

    {VAR:order_delivery_address_salutation} {VAR:order_delivery_address_firstname} {VAR:order_delivery_address_lastname}
	{VAR:order_delivery_address_street}
	{VAR:order_delivery_address_zip} {VAR:order_delivery_address_city}
	{VAR:order_delivery_address_country}

	E-Mail: {VAR:order_delivery_address_email}

-----

3. Bezahlart

	Zahlungsmethode: {SWITCH("{VAR:order_payment_method}")} {CASE("paypal")}PayPal{BREAK} {CASE("giropay")}GiroPay{BREAK} {CASE("ueberweisung")}Überweisung{BREAK} {CASE("bargeld")}Bargeld{BREAK} {ENDSWITCH}
	Betrag:  {VAR:order_amount} EUR

-----

{IF({ISSET:order_message})}
----

4. Nachricht / Bemerkung

{VAR:order_message}
{ENDIF}



Vielen Dank für Ihre Bestellung - die wir zeitnah bearbeiten werden.

Ihr Jakobus-Team

