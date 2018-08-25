<div class="form-field form-field--text{IF({ISSET:validationErrors})} error{ENDIF}{IF({ISSET:required})} required{ENDIF}">
	<label for="{VAR:fieldName}">{VAR:fieldLabel}</label>
	<input type="text" id="{VAR:fieldName}" name="{VAR:fieldName}" value="{IF({ISSET:fieldValue})}{VAR:fieldValue}{ELSE}{VAR:cmt_default}{ENDIF}"{IF({ISSET:required})} required{ENDIF} aria-describedby="{VAR:cmt_fieldname}-help-text" />

	{IF ({ISSET:cmt_fielddesc})}
		<p class="form-field__info help-text" id="{VAR:cmt_fieldname}-help-text">
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

