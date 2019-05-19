{IF("{COUNT:pilgrimpasses}" != "0")}
<aside class="widget cart">
	<div class="widget__header">
		<h4 class="widget__title">Ihre Pilgerausweise <span class="badge">{COUNT:pilgrimpasses}</span></h4>
	</div>
	<div class="widget__body">
		{COUNT:pilgrimpasses} Pilgerausweis{IF("{COUNT:pilgrimpasses}" != "1")}e{ENDIF}:
		<ul>
			{LOOP VAR(pilgrimpasses)}
			<li>
				{VAR:pilgrimpass_salutation} {VAR:pilgrimpass_firstname} {VAR:pilgrimpass_lastname}
			</li>
			{ENDLOOP VAR}
		</ul>
		<p>
			<a class="pilgrimpass-abort" data-confirm-text="Sind Sie sicher, dass Sie die Bestellung abbrechen möchten?" href="{PAGEURL}?action=abort">Bestellung abbrechen</a><br>
			{IF("{PAGEID}" != "24")}
				<a class="button" href="{PAGEURL:24:de}?action=continue">Bestellung fortsetzen</a>
			{ENDIF}
		</p>
	</div>
</aside>
{ENDIF}
