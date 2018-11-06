<h4>Filtern</h4>
{IF({ISSET:eventSelect:VAR})}
<div class="serviceContainer">
	<div class="serviceContainerInner">
		<form id="registrationEvent" action="{SELFURL}" method="post">
			<span class="serviceText">Veranstaltung</span>
			<select name="eventId">
				<option value="0">Zeige Anmeldungen zu allen Veranstaltungen</option>
				{VAR:eventSelect}
			</select>
			<input type="submit" class="cmtButton" value="anzeigen" />
		</form>
	</div>	
</div>	
{ENDIF}
{IF({ISSET:courseSelect:VAR})}
<div class="serviceContainer">
	<div class="serviceContainerInner">
		<form id="registrationCourse" action="{SELFURL}" method="post">
			<span class="serviceText">Kurs</span>
			<select name="courseId">
				<option value="0">Zeige Anmeldungen zu allen Kursen</option>
				{VAR:courseSelect}
			</select>
			<input type="submit" class="cmtButton" value="anzeigen" />
		</form>
	</div>	
</div>	
{ENDIF}
