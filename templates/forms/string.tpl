<div class="form-field form-field--text{IF({ISSET:validationErrors})} error{ENDIF}">
	<label for="{VAR:fieldName}">{VAR:fieldLabel}</label>
	<input type="text" id="{VAR:fieldName}" name="{VAR:fieldName}" value="{IF({ISSET:fieldValue})}{VAR:fieldValue}{ELSE}{VAR:cmt_default}{ENDIF}" />

	{IF ({ISSET:cmt_fielddesc})}
		<p class="form-field__info">
			{VAR:cmt_fielddesc}
		</p>
	{ENDIF}

	{IF ({ISSET:validationErrors})}
		{LOOP VAR(validationErrors)}
			<p class="message">
				<!-- Tja, wat schreiben wir denn hier ... ?!? -->
			</p>
		{ENDLOOP VAR}
	{ENDIF}
</div>

