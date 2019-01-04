<!-- <table class="courses&#45;overview"> -->
	<!-- <caption> -->
		<h2 class="headline">Abendveranstaltungen</h2>
	<!-- </caption> -->
	<ul class="events">
		{LOOP VAR(events)}
			<li>
				{INCLUDE:PATHTOWEBROOT.'templates/events/teaser.tpl'}
			</li>
		{ENDLOOP VAR}
	</ul>

	<!-- <tbody> -->
	<!-- 	{LOOP VAR(events)} -->
	<!-- 	<tr> -->
	<!-- 		<td><img src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" /></td> -->
	<!-- 		<td>{VAR:event_begin_fmt}&#38;thinsp;&#38;ndash;&#38;thinsp;{VAR:event_end_fmt}</td> -->
	<!-- 		<td> -->
	<!-- 			<a href="{VAR:course_detail_url}">{VAR:course_title}</a> -->
	<!-- 		</td> -->
	<!-- 		<td></td> -->
	<!-- 	</tr> -->
	<!-- 	{ENDLOOP VAR} -->
	<!-- </tbody> -->
<!-- </table> -->
