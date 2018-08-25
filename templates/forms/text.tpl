<div class="form-field form-field--textarea{IF({ISSET:validationErrors})} error{ENDIF}{IF({ISSET:required})} required{ENDIF}>
	<label for="{VAR:fieldName}">{VAR:fieldLabel}</label>
	<textarea id="{VAR:fieldName}" name="{VAR:fieldName}"{IF({ISSET:required})} required{ENDIF}>{IF({ISSET:fieldValue})}{VAR:fieldValue}{ELSE}{VAR:cmt_default}{ENDIF}</textarea>

	{IF ({ISSET:cmt_fielddesc})}
		<p class="form-field__info">
			{VAR:cmt_fielddesc}
		</p>
	{ENDIF}

	{IF ({ISSET:validationErrors})}
		{LOOP VAR(validationErrors)}
			<p class="message">
				<!-- Tja, wat schreiben wir denn hier ... ?!? -->
				{I18N:validation-error/{VAR:cmt_fieldname}/{VAR:ruleName}}
			</p>
		{ENDLOOP VAR}
	{ENDIF}
</div>

