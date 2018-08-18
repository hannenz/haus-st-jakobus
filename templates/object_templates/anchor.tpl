{IF({LAYOUTMODE})}
	<div>
		<label>Eindeutiger Bezeichner für diesen Anker (ID)</label><br>
		<div><pre>{HEAD:1}</pre></div>
	</div>
{ELSE}
	<div id="{HEAD:1}" class="anchor" data-magellan-target="{HEAD:1}"></div>
{ENDIF}
