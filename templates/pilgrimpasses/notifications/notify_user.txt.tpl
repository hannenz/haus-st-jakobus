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

	{VAR:order_payment_method}
	Express: {IF({ISSET:order_express})}Ja{ELSE}Nein{ENDIF}
	Betrag:  {VAR:order_amount} EUR
	{IF("{VAR:order_payment_method}" == "giropay")}
	{ENDIF}

-----

{IF({ISSET:order_message})}
----

4. Nachricht / Bemerkung

{VAR:order_message}
{ENDIF}



Sie erhalten einen Benachrichtigung sobald die Pilgerausweise versendet wurden.
Vielen Dank,

Ihr Cursillo-Team

