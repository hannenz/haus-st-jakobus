<div class="form-field form-field--date{IF({ISSET:validationErrors})} error{ENDIF}">
	<label for="{VAR:fieldName}">{VAR:fieldLabel}</label>
	<input type="date" id="{VAR:fieldName}" name="{VAR:fieldName}" value="{IF({ISSET:fieldValue})}{VAR:fieldValue}{ELSE}{VAR:cmt_default}{ENDIF}" />
</div>

