{IF("{COUNT:pilgrimpasses}" != "0")}
<aside class="widget cart">
	<div class="widget__header">
		<h4 class="widget__title">Ihre Bestellung</h4>
	</div>
	<div class="widget__body">
		{COUNT:pilgrimpasses} Pilgerausweise:
		<ul>
			{LOOP VAR(pilgrimpasses)}
			<li>
				{VAR:pilgrimpass_salutation} {VAR:pilgrimpass_firstname} {VAR:pilgrimpass_lastname}
			</li>
			{ENDLOOP VAR}
		</ul>
		<p><a href="{PAGEURL:24:de}?action=abort">Bestellung abbrechen</a></p>
	</div>
</aside>
{ENDIF}
