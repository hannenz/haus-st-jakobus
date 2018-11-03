<table class="courses-overview">
	<caption><h2 class="headline">Veranstaltungen im {VAR:month_fmt}</h2></caption>
	<!-- <thead> -->
	<!-- 	<tr><td>Datum</td><td>Titel</td><td>Plätze</td></tr> -->
	<!-- </thead> -->
	<tbody>
		{LOOP VAR(events)}
		<tr>
			<td><img src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" /></td>
			<td>{VAR:event_begin_fmt}&thinsp;&ndash;&thinsp;{VAR:event_end_fmt}</td>
			<td>
				<a href="{VAR:course_detail_url}">{VAR:course_title}</a>
			</td>
			<td></td>
		</tr>
		{ENDLOOP VAR}
	</tbody>
</table>


