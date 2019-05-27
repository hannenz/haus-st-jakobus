{IF({ISSET:saveFailed:VAR})}
	<p class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</p>
{ENDIF}

<h2 class="headline">Pilgerausweise bestellen</h2>

<form id="pilgrimpass-form" action="" method="post" novalidate>
	<div id="form-container">
		{LOOP VAR(pilgrimpasses)}
			<fieldset class="fieldset">
				<legend>Persönliche Angaben</legend>
				<a class="remove-button">
					<span>Diesen Pilgerpass entfernen</span> 
					<svg class="icon" width="100" height="100" viewBox="0 0 100 100"> <path d="M 67.67767,18.180195 50,35.857864 32.32233,18.180195 18.180195,32.32233 35.857864,50 18.180195,67.67767 32.32233,81.819805 50,64.142136 67.67767,81.819805 81.819805,67.67767 64.142136,50 81.819805,32.32233 Z"> </svg>
				</a>

				<div class="grid-x grid-padding-x">
					<div class="cell medium-2">
						<div class="form-field form-field--select">
							<label for="pilgrimpass_salutation-1">Anrede</label>
							<select id="pilgrimpass_salutation-1" name="pilgrimpass_salutation[]">
								<option value="Herr" {IF("{VAR:pilgrimpass_salutation}" == "Herr")}selected{ENDIF}>Herr</option>
								<option value="Frau" {IF("{VAR:pilgrimpass_salutation}" == "Frau")}selected{ENDIF}>Frau</option>
							</select>
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_firstname})}error{ENDIF}">
							<label for="pilgrimpass_firstname-1">Vorname</label>
							<input type="text" value="{VAR:pilgrimpass_firstname}" name="pilgrimpass_firstname[]" id="pilgrimpass_firstname-1" required />
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_lastname})}error{ENDIF}">
							<label for="pilgrimpass_lastname-1">Nachname</label>
							<input type="text" value="{VAR:pilgrimpass_lastname}" name="pilgrimpass_lastname[]" id="pilgrimpass_lastname-1" required />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_street_address})}error{ENDIF}">
							<label for="pilgrimpass_street_address-1">Anschrift</label>
							<input type="text" value="{VAR:pilgrimpass_street_address}" name="pilgrimpass_street_address[]" id="pilgrimpass_street_address-1" required />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell small-2">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_zip})}error{ENDIF}">
							<label for="pilgrimpass_zip-1">PLZ</label>
							<input type="text" value="{VAR:pilgrimpass_zip}" name="pilgrimpass_zip[]" id="pilgrimpass_zip-1" required />
						</div>
					</div>
					<div class="cell small-6">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_city})}error{ENDIF}">
							<label for="pilgrimpass_city-1">Stadt</label>
							<input type="text" value="{VAR:pilgrimpass_city}" name="pilgrimpass_city[]" id="pilgrimpass_city-1" />
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_country})}error{ENDIF}">
							<label for="pilgrimpass_country-1">Land</label>
							<input type="text" value="{VAR:pilgrimpass_country}" name="pilgrimpass_country[]" list="countries" />
							<datalist id="countries">
								<option value="Afghanistan"></option>
								<option value="&Auml;gypten"></option>
								<option value="&Aring;landinseln"></option>
								<option value="Albanien"></option>
								<option value="Algerien"></option>
								<option value="Amerikanisch-Samoa"></option>
								<option value="Amerikanische Jungferninseln"></option>
								<option value="Amerikanische &Uuml;berseeinseln"></option>
								<option value="Andorra"></option>
								<option value="Angola"></option>
								<option value="Anguilla"></option>
								<option value="Antarktis"></option>
								<option value="Antigua und Barbuda"></option>
								<option value="&Auml;quatorialguinea"></option>
								<option value="Argentinien"></option>
								<option value="Armenien"></option>
								<option value="Aruba"></option>
								<option value="Ascension"></option>
								<option value="Aserbaidschan"></option>
								<option value="&Auml;thiopien"></option>
								<option value="Australien"></option>
								<option value="Bahamas"></option>
								<option value="Bahrain"></option>
								<option value="Bangladesch"></option>
								<option value="Barbados"></option>
								<option value="Belarus"></option>
								<option value="Belgien"></option>
								<option value="Belize"></option>
								<option value="Benin"></option>
								<option value="Bermuda"></option>
								<option value="Bhutan"></option>
								<option value="Bolivien"></option>
								<option value="Bonaire, Sint Eustatius und Saba"></option>
								<option value="Bosnien und Herzegowina"></option>
								<option value="Botsuana"></option>
								<option value="Brasilien"></option>
								<option value="Britische Jungferninseln"></option>
								<option value="Britisches Territorium im Indischen Ozean"></option>
								<option value="Brunei Darussalam"></option>
								<option value="Bulgarien"></option>
								<option value="Burkina Faso"></option>
								<option value="Burundi"></option>
								<option value="Cabo Verde"></option>
								<option value="Ceuta und Melilla"></option>
								<option value="Chile"></option>
								<option value="China"></option>
								<option value="Cookinseln"></option>
								<option value="Costa Rica"></option>
								<option value="C&ocirc;te d&rsquo;Ivoire"></option>
								<option value="Cura&ccedil;ao"></option>
								<option value="D&auml;nemark"></option>
								<option value="Deutschland"></option>
								<option value="Diego Garcia"></option>
								<option value="Dominica"></option>
								<option value="Dominikanische Republik"></option>
								<option value="Dschibuti"></option>
								<option value="Ecuador"></option>
								<option value="El Salvador"></option>
								<option value="Eritrea"></option>
								<option value="Estland"></option>
								<option value="Falklandinseln"></option>
								<option value="F&auml;r&ouml;er"></option>
								<option value="Fidschi"></option>
								<option value="Finnland"></option>
								<option value="Frankreich"></option>
								<option value="Franz&ouml;sisch-Guayana"></option>
								<option value="Franz&ouml;sisch-Polynesien"></option>
								<option value="Franz&ouml;sische S&uuml;d- und Antarktisgebiete"></option>
								<option value="Gabun"></option>
								<option value="Gambia"></option>
								<option value="Georgien"></option>
								<option value="Ghana"></option>
								<option value="Gibraltar"></option>
								<option value="Grenada"></option>
								<option value="Griechenland"></option>
								<option value="Gr&ouml;nland"></option>
								<option value="Guadeloupe"></option>
								<option value="Guam"></option>
								<option value="Guatemala"></option>
								<option value="Guernsey"></option>
								<option value="Guinea"></option>
								<option value="Guinea-Bissau"></option>
								<option value="Guyana"></option>
								<option value="Haiti"></option>
								<option value="Honduras"></option>
								<option value="Indien"></option>
								<option value="Indonesien"></option>
								<option value="Irak"></option>
								<option value="Iran"></option>
								<option value="Irland"></option>
								<option value="Island"></option>
								<option value="Isle of Man"></option>
								<option value="Israel"></option>
								<option value="Italien"></option>
								<option value="Jamaika"></option>
								<option value="Japan"></option>
								<option value="Jemen"></option>
								<option value="Jersey"></option>
								<option value="Jordanien"></option>
								<option value="Kaimaninseln"></option>
								<option value="Kambodscha"></option>
								<option value="Kamerun"></option>
								<option value="Kanada"></option>
								<option value="Kanarische Inseln"></option>
								<option value="Kasachstan"></option>
								<option value="Katar"></option>
								<option value="Kenia"></option>
								<option value="Kirgisistan"></option>
								<option value="Kiribati"></option>
								<option value="Kokosinseln"></option>
								<option value="Kolumbien"></option>
								<option value="Komoren"></option>
								<option value="Kongo-Brazzaville"></option>
								<option value="Kongo-Kinshasa"></option>
								<option value="Kosovo"></option>
								<option value="Kroatien"></option>
								<option value="Kuba"></option>
								<option value="Kuwait"></option>
								<option value="Laos"></option>
								<option value="Lesotho"></option>
								<option value="Lettland"></option>
								<option value="Libanon"></option>
								<option value="Liberia"></option>
								<option value="Libyen"></option>
								<option value="Liechtenstein"></option>
								<option value="Litauen"></option>
								<option value="Luxemburg"></option>
								<option value="Madagaskar"></option>
								<option value="Malawi"></option>
								<option value="Malaysia"></option>
								<option value="Malediven"></option>
								<option value="Mali"></option>
								<option value="Malta"></option>
								<option value="Marokko"></option>
								<option value="Marshallinseln"></option>
								<option value="Martinique"></option>
								<option value="Mauretanien"></option>
								<option value="Mauritius"></option>
								<option value="Mayotte"></option>
								<option value="Mexiko"></option>
								<option value="Mikronesien"></option>
								<option value="Monaco"></option>
								<option value="Mongolei"></option>
								<option value="Montenegro"></option>
								<option value="Montserrat"></option>
								<option value="Mosambik"></option>
								<option value="Myanmar"></option>
								<option value="Namibia"></option>
								<option value="Nauru"></option>
								<option value="Nepal"></option>
								<option value="Neukaledonien"></option>
								<option value="Neuseeland"></option>
								<option value="Nicaragua"></option>
								<option value="Niederlande"></option>
								<option value="Niger"></option>
								<option value="Nigeria"></option>
								<option value="Niue"></option>
								<option value="Nordkorea"></option>
								<option value="N&ouml;rdliche Marianen"></option>
								<option value="Nordmazedonien"></option>
								<option value="Norfolkinsel"></option>
								<option value="Norwegen"></option>
								<option value="Oman"></option>
								<option value="&Ouml;sterreich"></option>
								<option value="Pakistan"></option>
								<option value="Pal&auml;stinensische Autonomiegebiete"></option>
								<option value="Palau"></option>
								<option value="Panama"></option>
								<option value="Papua-Neuguinea"></option>
								<option value="Paraguay"></option>
								<option value="Peru"></option>
								<option value="Philippinen"></option>
								<option value="Pitcairninseln"></option>
								<option value="Polen"></option>
								<option value="Portugal"></option>
								<option value="Pseudo-Accents"></option>
								<option value="Pseudo-Bidi"></option>
								<option value="Puerto Rico"></option>
								<option value="Republik Moldau"></option>
								<option value="R&eacute;union"></option>
								<option value="Ruanda"></option>
								<option value="Rum&auml;nien"></option>
								<option value="Russland"></option>
								<option value="Salomonen"></option>
								<option value="Sambia"></option>
								<option value="Samoa"></option>
								<option value="San Marino"></option>
								<option value="S&atilde;o Tom&eacute; und Pr&iacute;ncipe"></option>
								<option value="Saudi-Arabien"></option>
								<option value="Schweden"></option>
								<option value="Schweiz"></option>
								<option value="Senegal"></option>
								<option value="Serbien"></option>
								<option value="Seychellen"></option>
								<option value="Sierra Leone"></option>
								<option value="Simbabwe"></option>
								<option value="Singapur"></option>
								<option value="Sint Maarten"></option>
								<option value="Slowakei"></option>
								<option value="Slowenien"></option>
								<option value="Somalia"></option>
								<option value="Sonderverwaltungsregion Hongkong"></option>
								<option value="Sonderverwaltungsregion Macau"></option>
								<option value="Spanien"></option>
								<option value="Spitzbergen und Jan Mayen"></option>
								<option value="Sri Lanka"></option>
								<option value="St. Barth&eacute;lemy"></option>
								<option value="St. Helena"></option>
								<option value="St. Kitts und Nevis"></option>
								<option value="St. Lucia"></option>
								<option value="St. Martin"></option>
								<option value="St. Pierre und Miquelon"></option>
								<option value="St. Vincent und die Grenadinen"></option>
								<option value="S&uuml;dafrika"></option>
								<option value="Sudan"></option>
								<option value="S&uuml;dgeorgien und die S&uuml;dlichen Sandwichinseln"></option>
								<option value="S&uuml;dkorea"></option>
								<option value="S&uuml;dsudan"></option>
								<option value="Suriname"></option>
								<option value="Swasiland"></option>
								<option value="Syrien"></option>
								<option value="Tadschikistan"></option>
								<option value="Taiwan"></option>
								<option value="Tansania"></option>
								<option value="Thailand"></option>
								<option value="Timor-Leste"></option>
								<option value="Togo"></option>
								<option value="Tokelau"></option>
								<option value="Tonga"></option>
								<option value="Trinidad und Tobago"></option>
								<option value="Tristan da Cunha"></option>
								<option value="Tschad"></option>
								<option value="Tschechien"></option>
								<option value="Tunesien"></option>
								<option value="T&uuml;rkei"></option>
								<option value="Turkmenistan"></option>
								<option value="Turks- und Caicosinseln"></option>
								<option value="Tuvalu"></option>
								<option value="Uganda"></option>
								<option value="Ukraine"></option>
								<option value="Ungarn"></option>
								<option value="Uruguay"></option>
								<option value="Usbekistan"></option>
								<option value="Vanuatu"></option>
								<option value="Vatikanstadt"></option>
								<option value="Venezuela"></option>
								<option value="Vereinigte Arabische Emirate"></option>
								<option value="Vereinigte Staaten"></option>
								<option value="Vereinigtes K&ouml;nigreich"></option>
								<option value="Vietnam"></option>
								<option value="Wallis und Futuna"></option>
								<option value="Weihnachtsinsel"></option>
								<option value="Westsahara"></option>
								<option value="Zentralafrikanische Republik"></option>
								<option value="Zypern"></option>
							</datalist>
						</div>
					</div>
				</div>
					<div class="grid-x grid-padding-x">
						<div class="cell medium-6">
							<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_phone})}error{ENDIF}">
								<label for="pilgrimpass_phone-1">Telefon</label>
								<input type="text" value="{VAR:pilgrimpass_phone}" name="pilgrimpass_phone[]" id="pilgrimpass_phone-1" />
							</div>
						</div>
						<div class="cell medium-6">
							<div class="form-field form-field--text required {IF({ISSET:error_pilgrimpass_email})}error{ENDIF}">
								<label for="pilgrimpass_email-1">E-Mail</label>
								<input type="text" value="{VAR:pilgrimpass_email}" name="pilgrimpass_email[]" id="pilgrimpass_email-1" required />
							</div>
						</div>
					</div>

				<!-- </fieldset> -->
				<!--  -->
				<!--  -->
				<!-- <fieldset class="fieldset"> -->
					<!-- <legend>Pilgerweg</legend> -->

					<div class="grid-x grid-padding-x">
						<div class="cell medium-4">
							<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_route})}error{ENDIF}">
								<label for="pilgrimpass_route-1">Pilgerweg</label>
								<select name="pilgrimpass_route[]" id="pilgrimpass_route-1">
									<option value="camino-de-santiago" {IF("{VAR:pilgrimpass_route}" == "camino-de-santiago")}selected{ENDIF}>Camino de Santiago</option>
									<option value="via-francigena" {IF("{VAR:pilgrimpass_route}" == "via-francigena")}selected{ENDIF}>Via Francigena</option>
								</select>
							</div>
						</div>
						<div class="cell medium-4">
							<div class="form-field form-field--date {IF({ISSET:error_pilgrimpass_start_date})}error{ENDIF}">
								<label>Startdatum (mind. 5 Tage in der Zukunft)</label>
								<input type="date" min="{VAR:startDateMin}" value="{VAR:pilgrimpass_start_date}" name="pilgrimpass_start_date[]" id="pilgrimpass_start_date" />
							</div>
						</div>
						<div class="cell medium-4">
							<div class="form-field form-field--text {IF({ISSET:error_pilgrimpass_start_location})}error{ENDIF}">
								<label for="pilgrimpass_start_location-1">Start (Ort)</label>
								<input type="text" value="{VAR:pilgrimpass_start_location}" name="pilgrimpass_start_location[]" id="pilgrimpass_start_location-1" />
							</div>
						</div>
					</div>

					<div class="grid-x grid-padding-x">
						<div class="cell medium-4">
							<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_motivation})}error{ENDIF}">
								<label for="pilgrimpass_motivation-1">Motivation</label>
								<select name="pilgrimpass_motivation[]" id="pilgrimpass_motivation-1">
									<option value="andere" {IF("{VAR:pilgrimpass_motivation}" == "andere")}selected{ENDIF}>Keine Angabe</option>
									<option value="spirituell" {IF("{VAR:pilgrimpass_motivation}" == "spirituell")}selected{ENDIF}>spirituell</option>
									<option value="kulturell" {IF("{VAR:pilgrimpass_motivation}" == "kulturell")}selected{ENDIF}>kulturell</option>
									<option value="religiös" {IF("{VAR:pilgrimpass_motivation}" == "religiös")}selected{ENDIF}>religiös</option>
									<option value="sportlich" {IF("{VAR:pilgrimpass_motivation}" == "sportlich")}selected{ENDIF}>sportlich</option>
								</select>
							</div>
						</div>
						<div class="cell medium-4">
							<div class="form-field form-field--select {IF({ISSET:error_pilgrimpass_transportation})}error{ENDIF}">
								<label for="pilgrimpass_transportation-1">Fortbewegungsmittel</label>
								<select name="pilgrimpass_transportation[]" id="pilgrimpass_transportation-1">
									<option value="zu-fuss" {IF("{VAR:pilgrimpass_transportation}" == "zu-fuss")}selected{ENDIF}>Zu Fuß</option>
									<option value="mit-dem-fahrrad" {IF("{VAR:pilgrimpass_transportation}" == "mit-dem-fahrrad")}selected{ENDIF}>Mit dem Fahrrad</option>
									<option value="andere" {IF("{VAR:pilgrimpass_transportation}" == "andere")}selected{ENDIF}>Anderes</option>
								</select>
							</div>
						</div>
					</div>

					<div class="grid-x grid-padding-x">
						<div class="cell">
							<div class="info">
								Die mit einem <span>*</span> gekennzeichneten Felder müssen ausgefüllt werden.
							</div>
						</div>
					</div>
				</fieldset>
			{ENDLOOP VAR}
		</div>


		<input type="hidden" value="{VAR:count}" name="count" id="count" />
		<input type="hidden" name="step" value="1" />
		<div class="action-area"> 
			<button type="submit" class="button" name="action" value="step1">Weiter</button>
			<button class="button" id="add-button">
				<svg class="icon" width="100" height="100" viewBox="0 0 100 100">
					<path d="M 40,15 V 40 H 15 V 60 H 40 V 85 H 60 V 60 H 85 V 40 H 60 V 15 Z" />
				</svg>
				<span>Pilgerpass hinzufügen</span>
			</button>
		</div>
	</form>


