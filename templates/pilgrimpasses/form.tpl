<form action="" method="post">
	<fieldset class="fieldset">
		<legend>Persönliche Angaben</legend>
		{VAR:pilgrimpass_firstname}
		{VAR:pilgrimpass_lastname}
		{VAR:pilgrimpass_birthday}
		{VAR:pilgrimpass_street_address}
		{VAR:pilgrimpass_country}
		{VAR:pilgrimpass_zip}
		{VAR:pilgrimpass_city}
		{VAR:pilgrimpass_phone}
		{VAR:pilgrimpass_email}
		{VAR:pilgrimpass_idnr}
	</fieldset>
	<fieldset class="fieldset">
		<legend>Pilgerweg</legend>
		{VAR:pilgrimpass_route}
		{VAR:pilgrimpass_start_date}
		{VAR:pilgrimpass_message}
		{VAR:pilgrimpass_start_location}
		{VAR:pilgrimpass_motivation}
		{VAR:pilgrimpass_transportation}
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
