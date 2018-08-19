<div class="form-field form-field--select{IF({ISSET:validationErrors})} error{ENDIF}">
	<label for="{VAR:fieldName}">{VAR:fieldLabel}</label>
	<select id="{VAR:fieldName}" name="{VAR:fieldName}">
		{LOOP VAR(options)}
			<option value="{VAR:optionValue}">{VAR:optionName}</option>
		{ENDLOOP VAR}
	</select>
	{IF ({ISSET:cmt_fielddesc})}
		<p class="form-field__info">
			{VAR:cmt_fielddesc}
		</p>
	{ENDIF}
</div>


