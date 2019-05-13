
<form action="" method="post">

	{IF({ISSET:saveFailed:VAR})}
		<div class="error message">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</div>
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
		<div class="grid-x grid-padding-x"> 
			<div class="cell">
				<div class="action-area">
					<a class="" href="{VAR:course_detail_url}">Zurück</a>
					<button type="submit" class="button">Anmelden</button>
				</div>
			</div>
		</div>
	</fieldset>


</form>
