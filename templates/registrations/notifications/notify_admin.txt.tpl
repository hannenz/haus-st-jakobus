Eine Anmeldung ist eingegangen

Name: 			{VAR:registration_salutation} {VAR:registration_firstname} {VAR:registration_lastname}
Anschrift: 		{VAR:registration_street_address}
				{VAR:registration_zip} {VAR:registration_city}
Telefon: 		{VAR:registration_phone}
E-Mail: 		{VAR:registration_email}
Geburtstag: 	{VAR:registration_birthday}
Mitglied im Förderverein: {IF("{VAR:registration_is_member}" == "1")}Ja{ELSE}Nein{ENDIF}

Kurs: {VAR:course_name}
Veranstaltung: {VAR:event_title} am {VAR:event_date_fmt}

