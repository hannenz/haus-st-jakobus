{IF({LAYOUTMODE})}
	<form>
		<label>Wählen Sie ein Fotoalbum</label>
		<select id="cat-select-{UNIQUEID:new}" onchange="javascript:document.getElementById('cat-{UNIQUEID}').innerHTML = this.value;">
			<option value="0">-- Bitte wählen --</option>
			{LOOP TABLE(gallery_categories)}
				<option value="{FIELD:id}">{FIELD:gallery_category_title}</option>
			{ENDLOOP TABLE}
		</select>
	</div>
	<div id="cat-{UNIQUEID}" style="display:block;">{HEAD:1}</div>
	<script>
		document.addEventListener('DOMContentLoaded', function() { 
			var v = parseInt(document.getElementById('cat-{UNIQUEID}').innerHTML);
			if (v >= 0) {
				document.getElementById('cat-select-{UNIQUEID}').value = v;
			}
		});
	</script>
{ELSE}
	{INCLUDE:PATHTOWEBROOT.'phpincludes/fotoalbum/fotoalbum_controller.php'}
{ENDIF}
