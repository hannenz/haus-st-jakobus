<h3 class="">{VAR:course_category_name}</h3>

{IF({COUNT:events} == 0)}
	<p>
		Zur Zeit gibt es keine Veranstaltungen in der Kategorie <i>&bdquo;{VAR:course_category_name}&ldquo;</i>.<br>
		&rarr; Bitte wählen Sie eine andere Kategorie in der Auswahl
	</p>
{ELSE}
	<p>{COUNT:events} Veranstaltungen</p>
	<div class="events events--by-category">
		{LOOP VAR(events)}
			{INCLUDE:PATHTOWEBROOT."templates/events/teaser.tpl"}
		{ENDLOOP VAR}
	</div>
{ENDIF}
