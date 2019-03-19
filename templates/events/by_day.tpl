	<h2 class="headline">Veranstaltungen am {VAR:date_fmt}</h2>
		{LOOP VAR(events)}
			{INCLUDE:PATHTOWEBROOT."templates/events/teaser.tpl"}
		{ENDLOOP VAR}


