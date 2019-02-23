<article class="teaser teaser--event">

	<figure class="teaser__image">
		<a href="{VAR:course_detail_url}">
			{IF({ISSET:event_image})}
				<img src="/media/events/thumbnails/square/{VAR:event_image}" alt="" />
			{ELSE}
				{IF({ISSET:course_image})}
					<img src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
				{ENDIF}
			{ENDIF}
		</a>
	</figure>

	<div class="teaser__body">
		<header class="teaser__header">
			<div class="teaser__meta">{VAR:event_date_fmt}</div>
			<h3 class="kicker">{VAR:course_title}</h3>
			<h2 class="headline">{VAR:event_title}</h2>
			<div class="teaser__text">
				<!-- {VAR:post_teaser} -->
			</div>
		</header>

		<p>{VAR:event_location}</p>

		<div class="event-availability">

			{IF("{VAR:event_needs_registration}" == "0")}
				<p>Keine Anmeldung erforderlich</p>
			{ELSE}
				{IF("{VAR:event_seats_max}" == "0")}
					<p>Keine Teilnehmerbegrenzung</p>
				{ELSE}
					{INCLUDE:PATHTOWEBROOT.'templates/partials/availability_indicator.tpl'}
					{IF("{VAR:event_seats_taken}" != "{VAR:event_seats_max}")}
						{VAR:event_seats_available} Plätze frei
					{ELSE}
						Diese Veranstaltung ist ausgebucht
					{ENDIF}
				{ENDIF}
			{ENDIF}

		</div>

		<p class="teaser__action-area">
			<!-- <a class="more" href="{VAR:event_detail_url}">Details</a> -->
			{IF("{VAR:event_can_registrate}" == "1")}
				<a class="subscribe more" href="{VAR:event_subscribe_url}">Anmelden</a>
			{ENDIF}
		</p>
	</div>
</article>

