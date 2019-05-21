<table style="margin-top: 16px; margin-bottom: 16px">
	<tr>
		<td style="width: 140px">
			<a href="https://{VAR:host}{VAR:course_detail_url}">
				<img src="/media/courses/{VAR:course_image}" alt="" width="140" />
			</a>
		</td>
		<td style="width: 400px">
			<h3 class="kicker">{VAR:course_title}</h3>
			<h2 class="headline">{VAR:event_title}</h2>
			<p>
				<em>Beginn: {DATEFMT:"{VAR:event_begin}":"%a, %d. %B %Y %H:%M Uhr":de_DE.UTF-8} {IF({ISSET:event_begin_annotation})}{VAR:event_begin_annotation}{ENDIF}</em><br>
				<em>Ende: {DATEFMT:"{VAR:event_end}":"%a, %d. %B %Y %H:%M Uhr":de_DE.UTF-8} {IF({ISSET:event_end_annotation})}{VAR:event_end_annotation}{ENDIF}</em>
			</p>

			<p style="margin-top: 16px"> <a style="" href="https://{VAR:host}{VAR:course_detail_url}"> Details und Anmeldung </a> </p>

		</td>
	</tr>
</table>

