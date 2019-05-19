{IF("{VAR:passes_count}" == "1")}
Ein Pilgerausweis wurde beantragt mit folgenden Daten:
{ELSE}
Es wurden {VAR:passes_count} Pilgerausweise beantragt mit folgenden Daten:
{ENDIF}

-----

1. Pilgerausweise:

{LOOP VAR(pilgrimpasses)}
	Anrede:                 {VAR:pilgrimpass_salutation}
	Vorname:                {VAR:pilgrimpass_firstname}
	Nachname:               {VAR:pilgrimpass_lastname}
	Adresse:                {VAR:pilgrimpass_street_address}
	PLZ:                    {VAR:pilgrimpass_zip}
	Ort:                    {VAR:pilgrimpass_city}
	Land:                   {VAR:pilgrimpass_country}
	E-Mail:                 {VAR:pilgrimpass__email}
	Pilgerweg:              {SWITCH("{VAR:pilgrimpass_route}")} {CASE("camino-de-santiago")}Camino de Santiago{BREAK} {CASE("via-francigena")}Via Francigena{BREAK} {ENDSWITCH}
	Startdatum:             {VAR:pilgrimpass_start_date}
	Start (Ort):            {VAR:pilgrimpass_start_location}
	Motivation:             {SWITCH("{VAR:pilgrimpass_motivation}")} {CASE("religiös")}religiös{BREAK} {CASE("religiös-kulturell")}religiös/kulturell{BREAK} {CASE("kulturell-sportlich")}kulturell/sportlich{BREAK} {CASE("religiös-sportlich")}religiös/sportlich{BREAK} {ENDSWITCH}
	Fortbewegungsmittel:    {SWITCH("{VAR:pilgrimpass_transportation}")} {CASE("zu-fuss")}Zu Fuß{BREAK} {CASE("mit-dem-fahrrad")}Mit dem Fahrrad{BREAK} {CASE("auf-dem-pferd")}Auf dem Pferd{BREAK} {ENDSWITCH}

	---

{ENDLOOP VAR}


-----

2. Lieferadresse

Anrede:                 {VAR:order_delivery_address_salutation}
Vorname:                {VAR:order_delivery_address_firstname}
Nachname:               {VAR:order_delivery_address_lastname}
Adresse:                {VAR:order_delivery_address_street_address}
PLZ:                    {VAR:order_delivery_address_zip}
Ort:                    {VAR:order_delivery_address_city}
Land:                   {VAR:order_delivery_address_country}
E-Mail:                 {VAR:order_delivery_address_email}

-----

3. Bezahlung

Zahlungsmethode:        {SWITCH("{VAR:order_payment_method}")} {CASE("giropay")}GiroPay{BREAK} {CASE("ueberweisung")}Überweisung{BREAK} {CASE("bargeld")}Bargeld{BREAK} {ENDSWITCH}
Betrag:                 {VAR:order_amount} EUR
Express:                {IF("{VAR:order_express}" == "0")}Nein{ELSE}Ja{ENDIF}
{IF("{VAR:order_payment_method}" == "giropay")}
{ENDIF}

{IF({ISSET:order_message})}
-----

4. Nachricht

{VAR:order_message}
{ENDIF}

