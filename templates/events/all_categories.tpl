<section class="events-by-category">
	<!-- <h2 class="headline">Veranstaltungen nach Kategorie</h2> -->
	<ul style="list-style: none">
		{LOOP VAR(categories)}
			<li>
				<h3 class="headline headline--section-title">{VAR:course_category_name}</h3>
				{IF("{COUNT:Events}" != "0")}
				<!-- <h4>Veranstaltungen</h4> -->
				<ul>
					{LOOP VAR(Events)}
					<li>
						{INCLUDE:PATHTOWEBROOT.'templates/events/teaser.tpl'}
					</li>
					{ENDLOOP VAR}
				</ul>
				{ELSE}
				<p><i>Zur Zeit keine Veranstaltungen in dieser Kategorie</i></p>
				{ENDIF}
			</li>
		{ENDLOOP VAR}
	</ul>
</section>

