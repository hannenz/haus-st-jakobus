<h2 class="headline">Veranstaltungen {VAR:year}</h2>


<ul class="events">
	{LOOP VAR(events)}
		<li>
			{INCLUDE:PATHTOWEBROOT . 'templates/events/teaser.tpl'}
		</li>
	{ENDLOOP VAR}
</ul>


<!--table class="events-table">
	<thead>
	</thead>
	<tbody>
		{LOOP VAR(events)}
			<tr>
				<td>
					<a href="{VAR:course_detail_url}">
						<img src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
					</a>
				</td>
				<td>
					<div class="teaser__meta">{VAR:event_begin_fmt}&thinsp;&ndash;&thinsp;{VAR:event_end_fmt}</div>
					<h3 class="kicker">{VAR:course_title}</h3>
					<h2 class="headline">{VAR:event_title}</h2>
				</td>
			</tr>
		{ENDLOOP VAR}
	</tbody>
</table-->
