
{IF({ISSET:saveFailed:VAR})}
	<div class="error">Bitte prüfen Sie Ihre Eingabe und versuchen Sie es noch einmal!</div>
{ENDIF}

<form action="" method="post">
	<fieldset class="fieldset">
		<legend>Persönliche Angaben</legend>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				{VAR:pilgrimpass_firstname}
			</div>
			<div class="cell medium-6">
				{VAR:pilgrimpass_lastname}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell">
				{VAR:pilgrimpass_street_address}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell small-3">
				{VAR:pilgrimpass_zip}
			</div>
			<div class="cell small-9">
				{VAR:pilgrimpass_city}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				{VAR:pilgrimpass_country}
			</div>
			<div class="cell medium-6">
				{VAR:pilgrimpass_birthday}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-6">
				{VAR:pilgrimpass_phone}
			</div>
			<div class="cell medium-6">
				{VAR:pilgrimpass_email}
			</div>
		</div>
		
		<div class="grid-x grid-padding-x">
			<div class="cell">
				{VAR:pilgrimpass_idnr}
			</div>
		</div>
	</fieldset>


	<fieldset class="fieldset">
		<legend>Pilgerweg</legend>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-4">
				{VAR:pilgrimpass_route}
			</div>
			<div class="cell medium-4">
				{VAR:pilgrimpass_start_date}
			</div>
			<div class="cell medium-4">
				{VAR:pilgrimpass_start_location}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell medium-4">
				{VAR:pilgrimpass_motivation}
			</div>
			<div class="cell medium-4">
				{VAR:pilgrimpass_transportation}
			</div>
		</div>

		<div class="grid-x grid-padding-x">
			<div class="cell">
				{VAR:pilgrimpass_message}
			</div>
		</div>
	</fieldset>


	<fieldset class="fieldset">
		<legend>Bezahlung</legend>
		{VAR:pilgrimpass_payment_method}
		{VAR:pilgrimpass_express}
		{VAR:pilgrimpass_amount}
		{VAR:pilgrimpass_blz}
	</fieldset>
	<div> 
		<button type="submit" class="button">Absenden</button>
	</div>
</form>
