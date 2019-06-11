{IF({ISSET:error:VAR})}
<div class="error message message--error">
	{SWITCH("{VAR:error}")}
		{CASE("invalid-input")}
			<p>Bitte prüfen Sie Ihre Eingabe und versuchen Sie es erneut</p>
		{BREAK}
		{CASE("payment-failed")}
		<p>Die Zahlung konnte nicht durchgeführt werden oder wurde abgebrochen.<br>Bitte versuchen Sie es erneut oder nehmen Sie Kontakt zu uns auf.</p>
		{BREAK}
		{CASE()}
			<p>Bitte prüfen Sie das Formular und versuchen Sie es erneut</p>
		{BREAK}
	{ENDSWITCH}
	{IF({ISSET:error_donation_too_small_for_receipt})}
		<p>Eine Spendenquittung können wir Ihnen erst ab einer Spendenhöhe von <b>50,00 &euro;</b> ausstellen</p>
	{ENDIF}
	{IF({ISSET:errorMessage})}
	<p>
		<b>Fehlermeldung:</b><br>
		<code>{VAR:errorMessage:nl2br}</code>
	</p>
	{ENDIF}
	{IF({ISSET:error_data_privacy_statement_accepted})}
		<p>Sie müssen unseren Datenschutzbestimmungen zustimmen, damit wir Ihre Daten verarbeiten können</p>
	{ENDIF}
</div>
{ENDIF}

<form class="form" action="{VAR:donationUrl}" method="post" accept-charset="utf-8">
	
	<fieldset class="fieldset">
		<legend>Jetzt online spenden</legend>

		<div class="grid-x grid-padding-x">
			<div class="cell small-4">
				<div class="form-field form-field--text {IF({ISSET:error_amount})}error{ENDIF}">
					<label for="amount">Ich spende einmalig einen Betrag in Höhe von</label>
					<input type="text" name="amount" id="amount" value="{VAR:amount}" placeholder="50">
				</div>
			</div>
			<div class="cell small-4">
				<div class="form-field form-field--select">
					<label for="payment_method">Ich bezahle mit …</label>
					<select name="payment_method">
						<option value="paypal" {IF("{VAR:payment_method}" == "paypal")}selected{ENDIF}>PayPal</option>
						<option value="giropay" {IF("{VAR:payment_method}" == "giropay")}selected{ENDIF}>Giropay</option>
					</select>
				</div>
			</div>
			<div class="cell small-4">
				<div class="form-field">
					<label>&nbsp;</label>
					<button type="submit" class="button">Jetzt spenden</button>
				</div>
			</div>
		</div>

		<details{IF({ISSET:wantsReceipt})} open{ENDIF}>
			<summary class="cell">Ich benötige eine Spendenquittung</summary>
			<div>
				<div class="grid-x grid-padding-x">
					<div class="info cell">
						Ab einer Höhe von 50,00 &euro; stellen wir Ihnen gerne
						eine Spendenquittung aus. Bitte tragen Sie in diesem
						Fall hier Ihre persönlichen Daten ein, damit wir Ihnen
						die Spendenquittung postalisch zustellen können. Die
						Daten werden nur zu diesem Zweck erhoben und nicht
						weiter gespeichert.
					</div>
				</div>
				<div class="grid-x grid-padding-x">
					<div class="cell medium-2">
						<div class="form-field form-field--select">
							<label for="donation_salutation">Anrede</label>
							<select id="donation_salutation" name="donation_salutation">
								<option value="">-- bitte wählen --</option>
								<option value="Frau" {IF("{VAR:donation_salutation}" == "Frau")}selected{ENDIF}>Frau</option>
								<option value="Herr" {IF("{VAR:donation_salutation}" == "Herr")}selected{ENDIF}>Herr</option>
							</select>
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text {IF({ISSET:error_donation_firstname})}error{ENDIF}">
							<label for="donation_firstname">Vorname</label>
							<input type="text" value="{VAR:donation_firstname}" name="donation_firstname" id="donation_firstname" />
						</div>
					</div>
					<div class="cell medium-5">
						<div class="form-field form-field--text {IF({ISSET:error_donation_lastname})}error{ENDIF}">
							<label for="donation_lastname">Nachname</label>
							<input type="text" value="{VAR:donation_lastname}" name="donation_lastname" id="donation_lastname" />
						</div>
					</div>
				</div>
				<div class="grid-x grid-padding-x">
					<div class="cell">
						<div class="form-field form-field--text {IF({ISSET:error_donation_street_address})}error{ENDIF}">
							<label for="donation_street_address">Anschrift</label>
							<input type="text" value="{VAR:donation_street_address}" name="donation_street_address" id="donation_street_address" />
						</div>
					</div>
				</div>

				<div class="grid-x grid-padding-x">
					<div class="cell small-2">
						<div class="form-field form-field--text {IF({ISSET:error_donation_zip})}error{ENDIF}">
							<label for="donation_zip">PLZ</label>
							<input type="text" value="{VAR:donation_zip}" name="donation_zip" id="donation_zip" />
						</div>
					</div>
					<div class="cell small-6">
						<div class="form-field form-field--text {IF({ISSET:error_donation_city})}error{ENDIF}">
							<label for="donation_city">Stadt</label>
							<input type="text" value="{VAR:donation_city}" name="donation_city" id="donation_city" />
						</div>
					</div>
					<div class="cell medium-4">
						<div class="form-field form-field--text {IF({ISSET:error_donation_country})}error{ENDIF}">
							<label for="donation_country">Land</label>
							<input type="text" value="{VAR:donation_country}" name="donation_country" list="countries" />
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
			</div>

			<div class="form-field form-field--flag {IF({ISSET:error_data_privacy_statement_accepted})}error{ENDIF}">
				<input type="checkbox" name="data-privacy-statement-accepted" id="data-privacy-statement-accepted" />
				<label for="data-privacy-statement-accepted">Ich habe die <a href="{PAGEURL:58}" target="_blank">Datenschutzerklärung</a> gelesen und erkläre mich hiermit einverstanden</label>
			</div>
		</details>
	</fieldset>
	<!-- <div class="action&#45;area"> -->
	<!-- 	<button type="submit" class="butto">Jetzt spenden</button> -->
	<!-- </div> -->
</form>
