<style type="text/css" media="screen">
.course-manager-events {
	border-collapse: collapse;
}

.course-manager-events td {
	vertical-align: top;
	padding: 6px;
}
</style>
<div class="tableHeadlineContainer">
	<div class="tableIcon">
		<img src="templates/default/administration/img/default_table_icon_xlarge.png" alt="" />
	</div>
	<h1>Kurs-Manager</h1>
</div>

<div class="course-manager-overview">
	<div class="cmtTabs">
		<ul>
			<li><a href="#tabs-1">Vergangene Veranstaltungen</a></li>
			<li><a href="#tabs-2">Anstehende Veranstaltungen</a></li>
		</ul>
		<div id="tabs-1">
			<table class="course-manager-events">
				{LOOP VAR(pastEvents)}
				<tr class="course">
					<td>
						{VAR:event_begin} &mdash; <br>
						{VAR:event_end}
					<td>
						<img style="width:160px" src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
					</td>
					<td>
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
						<a class="cmtIcon cmtButtonEditEntry"href="{SELFURL}&cmtApplicationID=147&cmt_dbtable=jakobus_events&&action=edit&id[]={VAR:id}"></a>
						<!-- <a class="cmtIcon cmtButtonDeleteEntry"href="{SELFURL}&#38;cmtAction=delete&#38;id[]={VAR:id}"></a> -->
					</td>
				</tr>
				{ENDLOOP VAR}
			</table>
		</div>
		<div id="tabs-2">
			<table class="course-manager-events">
				{LOOP VAR(upcomingEvents)}
				<tr class="course">
					<td>
						{VAR:event_begin} &mdash; <br>
						{VAR:event_end}
					<td>
						<img style="width:160px" src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
					</td>
					<td>
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
						<a class="cmtIcon cmtButtonEditEntry"href="{SELFURL}&cmtAction=edit&id[]={VAR:id}"></a>
						<a class="cmtIcon cmtButtonDeleteEntry"href="{SELFURL}&cmtAction=delete&id[]={VAR:id}"></a>
					</td>
				</tr>
				{ENDLOOP VAR}
			</table>
		</div>
	</div>
</div>

