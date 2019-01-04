<div id="events-for-month-{VAR:year}-{VAR:month}" class="events">
	<h2 class="headline">{VAR:month_fmt}</h2>

	<ul class="events">
		{LOOP VAR(events)}
			<li>
				{INCLUDE:PATHTOWEBROOT."templates/events/teaser.tpl"}
			</li>
		{ENDLOOP VAR}
	</ul>
</div>


