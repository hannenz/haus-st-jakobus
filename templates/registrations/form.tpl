<form id="registration" action="" method="post">

	{IF({ISSET:saveFailed:VAR})}
		<div class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</div>
	{ENDIF}
	{IF({ISSET:data-privacy-statement-not-accepted})}
		<p class="error message message--error">Sie müssen unserer Datenschutzerklärung zustimmen, damit wir Ihre Anmeldung verarbeiten können.</p>
	{ENDIF}

	<fieldset class="fieldset">
		<legend>Anmeldung zur Veranstaltung</legend>
		<div>
			<strong>Kurs: {VAR:course_title}</strong><br>
			<em>Termin: {VAR:event_date_fmt}</em>
			<input type="hidden" readonly name="registration_event_id" value="{VAR:id}" />
		</div>
		<div>
	</fieldset>

	<fieldset class="fieldset">
		<legend>Persönliche Angaben</legend>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-3">
				{VAR:registration_salutation}
			</div>
			<div class="cell medium-4">
				{VAR:registration_firstname}
			</div>
			<div class="cell medium-5">
				{VAR:registration_lastname}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell">
				{VAR:registration_street_address}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell small-3">
				{VAR:registration_zip}
			</div>
			<div class="cell small-9">
				{VAR:registration_city}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				<label for="registration_country">Land</label>
				<input id="registration_country" type="text" value="" name="registration_country" />
			</div>
		</div>


		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				{VAR:registration_email}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				{VAR:registration_is_member}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				<div class="info">
					Die mit einem <span>*</span> gekennzeichneten Felder müssen ausgefüllt werden.
				</div>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset">
		<legend>Datenschutz</legend>
		<div class="form-field form-field--flag">
			<input type="checkbox" name="data-privacy-statement-accepted" id="data-privacy-statement-accepted" />
			<label for="data-privacy-statement-accepted">Ich habe die <a href="{PAGEURL:58}" target="_blank">Datenschutzerklärung</a> gelesen und erkläre mich hiermit einverstanden</label>
		</div>
	</fieldset>

	<div class="action-area">
		<button type="submit" class="button">Anmelden</button>
		<a class="" href="{VAR:course_detail_url}">Zurück</a>
	</div>

</form>
