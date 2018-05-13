{IF (!{LAYOUTMODE})}
{EVAL}
if ($cmt_content['head1']) {
	include(PATHTOWEBROOT."phpincludes/widgets/".$cmt_content['head1']);
}
{ENDEVAL}
{ELSE}
{EVAL}
$id = rand();
{ENDEVAL}
<div>Widget verwenden:<br />
<select name="widget_file" id="widget{USERVAR:id}" onchange="document.getElementById('damalsSelectedWidgetInclude{USERVAR:id}').firstChild.innerHTML = this.value">
<option value="">-- Widget aussuchen --</option>
{LOOP TABLE(widgets:ORDER BY widget_name)}<option value="{FIELD:widget_include}"{IF ("{HEAD:1}" == "{FIELD:widget_include}")} selected="selected"{ENDIF}>{FIELD:widget_name}</option>{ENDLOOP TABLE}
</select>
</div>
<div>
<div id="damalsSelectedWidgetInclude{USERVAR:id}" style="display: none;"><div>{HEAD:1}</div></div>
<script type="text/javascript">
var head1 = document.getElementById('damalsSelectedWidgetInclude{USERVAR:id}').firstChild.firstChild.innerHTML;
console.log (head1);
document.getElementById('widget{USERVAR:id}').value = document.getElementById('damalsSelectedWidgetInclude{USERVAR:id}').firstChild.firstChild.innerHTML;
</script>
{ENDIF}
