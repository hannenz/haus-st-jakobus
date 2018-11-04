{IF (!{LAYOUTMODE})}
{EVAL}
if ($cmt_content['head1']) {
	$db = new Contentomat\DBCex();
	$db->query(sprintf('SELECT * FROM widgets WHERE id=%u', (int)$cmt_content['head1']));
	$widget = $db->get();

	if (!empty($widget['widget_include']) && is_readable(PATHTOWEBROOT."phpincludes/widgets/".$widget['widget_include'])) {
		include(PATHTOWEBROOT."phpincludes/widgets/".$widget['widget_include']);
	}
		

	$parser = new Contentomat\Parser();

	$content .= $parser->parse($widget['widget_html']);
}
{ENDEVAL}
{ELSE}
<div>
	<div>
		Widget verwenden:<br />
		<select name="widget_file" id="widget{UNIQUEID:new}" onchange="document.getElementById('selectedWidget{UNIQUEID}').innerHTML = this.value">
			<option value="">-- Widget aussuchen --</option>
			{LOOP TABLE(widgets:ORDER BY widget_name)}
				<option value="{FIELD:id}"{IF ("{HEAD:1}" == "{FIELD:id}")} selected="selected"{ENDIF}>{FIELD:widget_name}</option>
			{ENDLOOP TABLE}
		</select>
	</div>
	<div id="selectedWidget{UNIQUEID}" style="display: none;">{HEAD:1}</div>

	<script>
		var head1 = document.getElementById('selectedWidget{UNIQUEID}').innerText;
		console.log (head1);
		document.getElementById('widget{UNIQUEID}').value = head1;
	</script>
</div>
{ENDIF}
