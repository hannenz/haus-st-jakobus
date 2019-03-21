<div>
<link rel="stylesheet" href="/dist/css/coursemanager.css" type="text/css" />
<style type="text/css" media="screen"></style>
<div class="tableHeadlineContainer">
	<div class="tableIcon">
		<img src="templates/default/administration/img/default_table_icon_xlarge.png" alt="" />
	</div>
	<h1>Kurs-Manager</h1>
</div>
<div class="serviceContainer">
	<div class="serviceContainerInner">
		<div class="serviceElementContainer">
			<a href="{SELFURL}&cmtAction=exportCsv" class="cmtButton">Anmeldungen exportieren (CSV / Excel)</a>
		</div>
		<div class="serviceElementContainer">
			<form id="filterByTypeForm" action="{SELFURL}" method="post">
				<span class="serviceText">Zeige Veransstaltungen:</span>
				<select name="type" id="selectFilterByType">
					{VAR:filterByTypeSelect}
				</select>
			</form>
		</div>
	</div>
</div>

<div class="course-manager-overview">
	<div class="cmtTabs">
		<ul>
			<li><a href="#tabs-2">Anstehende Veranstaltungen</a></li>
			<li><a href="#tabs-1">Vergangene Veranstaltungen</a></li>
		</ul>
		<div id="tabs-2">
			<table class="course-manager-events">
				{LOOP VAR(upcomingEvents)}
				<tr class="course">
					<td>
						<img style="width:160px" src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
					</td>
					<td>
						{IF({VAR:event_is_soiree})}<div class="badge badge--soiree">Abendveranstaltung</div>{ENDIF}
						<div> {VAR:event_begin_fmt} &mdash; {VAR:event_end_fmt} </div>
						<div> {VAR:event_time_fmt} Uhr</div>
						<h4>{VAR:course_title}</h4>
						<p>{VAR:course_short_description}</p>
					</td>
					<td>
						<details>
							<summary> {VAR:registrations_count} Anmeldungen</summary>
							<ul>
							{LOOP VAR(registrations)}
							<li><a href="/admin/cmt_applauncher.php?sid={SID}&cmtApplicationID=146&cmt_slider=1&cmt_dbtable=jakobus_registrations&id[]={VAR:id}&action=view">{VAR:registration_firstname} {VAR:registration_lastname} &lt;{VAR:registration_email}&gt;</a></li>
							{ENDLOOP VAR}
							</ul>
						</details>
					</td>
					<td>
						<form class="event-seats-taken-form" action="default_submit" action="{SELFURL}&action=updateSeatsTaken" method="post" accept-charset="utf-8">
							<label for="event-seats-taken">Belegte Plätze</label>
							<input type="number" value="{VAR:event_seats_taken}" name="event_seats_taken" id="event-seats-taken" />
							<input type="hidden" value="{VAR:id}" name="id" />
						</form>
					</td>
					<td>
						<a class="cmtIcon cmtButtonEditEntry" href="{SELFURL}&cmtApplicationID=147&cmt_dbtable=jakobus_events&action=edit&id[]={VAR:id}"></a>
						<a class="cmtIcon cmtButtonDeleteEntry cmtDialog cmtDialogConfirm" data-dialog-content-id="cmtDialogConfirmDeletion" data-dialog-var="{VAR:id}" data-dialog-confirm-url="{SELFURL}&cmtApplicationID=147&cmt_dbtable=jakobus_events&action=delete&id[]={VAR:id}" href="javascript:void(0);"></a>
					</td>
				</tr>
				{ENDLOOP VAR}
			</table>
		</div>
		<div id="tabs-1">
			<table class="course-manager-events">
				{LOOP VAR(pastEvents)}
				<tr class="course">
					<!-- <td> -->
					<!-- 	{VAR:event_begin_fmt} &#38;mdash; <br> -->
					<!-- 	{VAR:event_end_fmt} -->
					<!-- </td> -->
					<td>
						<img style="width:160px" src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
					</td>
					<td>
						<div> {VAR:event_begin_fmt} &mdash; {VAR:event_end_fmt} </div>
						<h4>{VAR:course_title}</h4>
						<p>{VAR:course_short_description}</p>
					</td>
					<td>
						<details>
							<summary> {VAR:registrations_count} Anmeldungen</summary>
							<ul>
							{LOOP VAR(registrations)}
							<li><a href="/admin/cmt_applauncher.php?sid={SID}&cmtApplicationID=146&cmt_slider=1&cmt_dbtable=jakobus_registrations&id[]={VAR:id}&action=view">{VAR:registration_firstname} {VAR:registration_lastname} &lt;{VAR:registration_email}&gt;</a></li>
							{ENDLOOP VAR}
							</ul>
						</details>
					</td>
					<td>
						<a class="cmtIcon cmtButtonEditEntry" href="{SELFURL}&cmtApplicationID=147&cmt_dbtable=jakobus_events&action=edit&id[]={VAR:id}"></a>
						<a class="cmtIcon cmtButtonDeleteEntry cmtDialog cmtDialogConfirm" data-dialog-content-id="cmtDialogConfirmDeletion" data-dialog-var="{VAR:id}" data-dialog-confirm-url="{SELFURL}&cmtApplicationID=147&cmt_dbtable=jakobus_events&action=delete&id[]={VAR:id}" href="javascript:void(0);"></a>
					</td>
				</tr>
				{ENDLOOP VAR}
			</table>
		</div>
	</div>
</div>

<!-- Dialogfenster Inhalte -->
<div id="cmtDialogConfirmDeletion" class="cmtDialogContentContainer">
	<div class="cmtDialogContent">
		M&ouml;chten Sie den Eintrag mit der ID-Nr. <span class="cmtDialogVar"></span> wirklich l&ouml;schen?
	</div>
	<div class="cmtDialogButtons">
		<span class="cmtButtonCancelText" data-button-class="cmtButtonBack">abbrechen</span>
		<span class="cmtButtonConfirmText" data-button-class="cmtButtonDelete">l&ouml;schen</span>
	</div>
</div>
</div>
<script>
	$(document).on('change', '[name=event_seats_taken]', function(ev) {
		var $form = $(this).parents('.event-seats-taken-form');
		var id = $form.find('input[name=id]').val();
		var url = $form.attr('action');
		$.post(url, $form.serialize(), function() { });
	});

	var $filterByTypeForm = $('#filterByTypeForm');
	$filterByTypeForm.find('select').on('change', function() {
		var url = $filterByTypeForm.attr('action');
		console.log(url);
		$.post(url, $filterByTypeForm.serialize(), function(response) {
			console.log($(response).find('.course-manager-overview'));
			// $('.course-manager-overview').replaceWith($(response).find('.course-manager-overview'));
			document.body.innerHTML = response;
		});
	});
</script>
