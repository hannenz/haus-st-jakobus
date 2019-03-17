<div class="availability-indicator">
	<svg class="" viewBox="0 0 30 30" width="30" height="30" xmlns="http://www.w3.org/2000/svg">
		<rect x="0" y="0" width="30" height="30" {IF("{VAR:event_seats_available}" == "0")}fill="#cc0000"{ELSE}{IF("{VAR:event_seats_available}" < "5")}fill="#ffa500"{ELSE}fill="#00cc00"{ENDIF}{ENDIF} />
	</svg>
	<progress class="availability {VAR:event_seats_availability_class}"min="0" max="100" value="{VAR:event_seats_perc}" title="{VAR:event_seats_available} Plätze frei"></progress>
	<div class="savailibility-indicator__label"></div>
</div>
