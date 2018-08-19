<div class="form-field form-field--flag{IF({ISSET:validationErrors})} error{ENDIF}">
	<input type="checkbox" id="{VAR:fieldName}" name="{VAR:fieldName}" {IF ("{VAR:fieldValue}" == "1" || "{VAR:cmt_default}")}checked{ENDIF} />
	<label for="{VAR:fieldName}">{VAR:fieldLabel}</label>
	{IF ({ISSET:validationErrors})}
		{LOOP VAR(validationErrors)}
			<p class="message">
				<!-- Tja, wat schreiben wir denn hier ... ?!? -->
			</p>
		{ENDLOOP VAR}
	{ENDIF}
</div>
