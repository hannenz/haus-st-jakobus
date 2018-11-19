<div id="events-for-month-{VAR:year}-{VAR:month}" class="events">
	<h2 class="headline headline--large">{VAR:month_fmt}</h2>
	{LOOP VAR(events)}
		{INCLUDE:PATHTOWEBROOT."templates/events/teaser.tpl"}
	{ENDLOOP VAR}
</div>


