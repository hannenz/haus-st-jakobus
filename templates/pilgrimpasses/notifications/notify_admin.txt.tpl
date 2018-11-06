Ein Pilgerausweis wurde beantragt

Anrede:                 {VAR:pilgrimpass_salutation}
Vorname:                {VAR:pilgrimpass_firstname}
Nachname:               {VAR:pilgrimpass_lastname}
Anrede:                 {VAR:pilgrimpass_salutation}
Geburtstag:             {VAR:pilgrimpass_birthday}
Adresse:                {VAR:pilgrimpass_street_address}
Land:                   {VAR:pilgrimpass_country}
PLZ:                    {VAR:pilgrimpass_zip}
Ort:                    {VAR:pilgrimpass_city}
Telefon:                {VAR:pilgrimpass__phone}
E-Mail:                 {VAR:pilgrimpass__email}
Personalausweis-Nummer: {VAR:pilgrimpass_idnr}
Pilgerweg:              {SWITCH("{VAR:pilgrimpass_route}")} {CASE("camino-de-santiago")}Camino de Santiago{BREAK} {CASE("via-francigena")}Via Francigena{BREAK} {ENDSWITCH}
Startdatum:             {VAR:pilgrimpass_start_date}
Start (Ort):            {VAR:pilgrimpass_start_location}
Motivation:             {SWITCH("{VAR:pilgrimpass_motivation}")} {CASE("religiös")}religiös{BREAK} {CASE("religiös-kulturell")}religiös/kulturell{BREAK} {CASE("kulturell-sportlich")}kulturell/sportlich{BREAK} {CASE("religiös-sportlich")}religiös/sportlich{BREAK} {ENDSWITCH}
Fortbewegungsmittel:    {SWITCH("{VAR:pilgrimpass_transportation}")} {CASE("zu-fuss")}Zu Fuß{BREAK} {CASE("mit-dem-fahrrad")}Mit dem Fahrrad{BREAK} {CASE("auf-dem-pferd")}Auf dem Pferd{BREAK} {ENDSWITCH}
Zahlungsmethode:        {SWITCH("{VAR:pilgrimpass_payment_method}")} {CASE("giropay")}GiroPay{BREAK} {CASE("ueberweisung")}Überweisung{BREAK} {CASE("bargeld")}Bargeld{BREAK} {ENDSWITCH}
Betrag:                 {VAR:pilgrimpass_amount}
Express:                {IF("{VAR:pilgrimpass_express}" == "0")}Nein{ELSE}Ja{ENDIF}
{IF("{VAR:pilgrimpass_payment_method}" == "giropay")}
BLZ:                    {VAR:pilgrimpass_blz}
{ENDIF}
Nachricht:              {VAR:pilgrimpass_message}
