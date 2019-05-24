<div id="events-for-month-{VAR:year}-{VAR:month}" class="events">
	<h2 class="headline headline--section-title">{VAR:month_fmt} <span style="font-weight: normal">{VAR:year}</span></h2>

	<ul class="events">
		{LOOP VAR(events)}
			<li>
				{INCLUDE:PATHTOWEBROOT."templates/events/teaser.tpl"}
			</li>
		{ENDLOOP VAR}
	</ul>
</div>


