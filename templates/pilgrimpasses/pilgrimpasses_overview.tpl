{IF({ISSET:cmtErrorMessage})}
<div class="message cmtMessage cmtMessageError">
	Export fehlgeschlagen: {VAR:cmtErrorMessage}
</div>
{ENDIF}
<div class="cmtServiceContainer">
	<div class="cmtServiceContainerInner">
		<span class="serviceText">Pilgerausweis-Daten als CSV-Datei exportieren</span><br>
		<button id="exportButton" class="cmtButton cmtButtonSave" data-dialog-content-id="cmtDialogSelectExportRange">Exportieren</button>
	</div>
</div>


<div id="cmtDialogSelectExportRange" class="cmtDialogContentContainer" title="Pilgerausweis-Daten exportieren">
	<form class="exportRangeForm" action="{SELFURL}" method="post">
		<div class="cmtDialogContainerInner">
			<div class="cmtDialogContent">
				<p>Wählen Sie den zu exportierenden Zeitraum:</p>
				<input type="hidden" name="cmtAction" value="exportCsv" />
				<input type="date" name="export_range_begin" value="{IF({ISSET:export_range_begin})}{VAR:export_range_begin}{ELSE}{VAR:defaultBegin}{ENDIF}" class="export-range-begin" /> &ndash; 
				<input type="date" name="export_range_end" value="{IF({ISSET:export_range_end})}{VAR:export_range_end}{ELSE}{VAR:defaultEnd}{ENDIF}" class="export-range-end" />
			</div>
			<div class="cmtDialogButtons" style="margin-top: 3rem">
				<button class="cmtButton cmtButtonBack">abbrechen</button>
				<button class="cmtButton cmtButtonSave" type="submit">Exportieren</button>
			</div>
		</div>
	</form>
</div>

<script>
jQuery(function() {

	jQuery('#exportButton').on('click', function(ev) {

		var dialogId = jQuery(this).attr('data-dialog-content-id');
		var $dialogEl = jQuery('#' + dialogId);

		var dialog = $dialogEl.dialog({
			resizable: false,
			title: $dialogEl.attr('title'),
			modal: true,
			width: 360,
			dialogClass: 'cmtDialogTypeConfirm'
		});

		jQuery('.cmtButtonBack', dialog).on('click', function(ev) {
			console.log('cancelled');
			jQuery(dialog).dialog('close');
			ev.preventDefault();
			return false;
		});

		jQuery('.cmtButtonSave', dialog).on('click', function(ev) {
		});
	});
});
</script>
