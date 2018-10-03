{IF({LAYOUTMODE})}
	<form>
		<label>Wählen Sie ein Fotoalbum</label>
		<select id="cat-select" onchange="javascript:document.getElementById('cat').innerHTML = this.value;">
			<option value="0">-- Bitte wählen --</option>
			{LOOP TABLE(gallery_categories)}
				<option value="{FIELD:id}">{FIELD:gallery_category_title}</option>
			{ENDLOOP TABLE}
		</select>
	</div>
	<div id="cat" style="display:none">{HEAD:1}</div>
	<script>
		document.addEventListener('DOMContentLoaded', function() { 
			var v = parseInt(document.getElementById('cat').innerHTML);
			if (v >= 0) {
				document.getElementById('cat-select').value = v;
			}
		});
	</script>
{ELSE}
	{INCLUDE:PATHTOWEBROOT.'phpincludes/fotoalbum_controller.php'}
{ENDIF}
