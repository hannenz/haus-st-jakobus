<article class="teaser teaser--event">

	<figure class="teaser__image">
		<a href="{VAR:course_detail_url}">
			{IF({ISSET:event_image})}
				<img class="lazy" data-src="/media/events/thumbnails/square/{VAR:event_image}" alt="" />
			{ELSE}
				{IF({ISSET:course_image:VAR})}
					<img class="lazy" data-src="/media/courses/thumbnails/square/{VAR:course_image}" alt="" />
				{ENDIF}
			{ENDIF}
		</a>
	</figure>

	<div class="teaser__body">
		<header class="teaser__header">
			<div class="teaser__meta">{VAR:event_date_fmt}</div>

			<h3 class="kicker">{VAR:course_title}</h3>
			<h2 class="headline">{VAR:event_title}</h2>
		</header>

		<div class="teaser__date-time">
			<p>
				<em>Beginn: {DATEFMT:"{VAR:event_begin}":"%a, %d. %B %Y %H:%M Uhr":de_DE.UTF-8} {IF({ISSET:event_begin_annotation})}{VAR:event_begin_annotation}{ENDIF}</em><br>
				<em>Ende: {DATEFMT:"{VAR:event_end}":"%a, %d. %B %Y %H:%M Uhr":de_DE.UTF-8} {IF({ISSET:event_end_annotation})}{VAR:event_end_annotation}{ENDIF}</em>
			</p>
		</div>

		<details>
			<summary class="teaser__details-trigger">Details & Anmeldung</summary>
			<div class="teaser__details-body">
				
				<div class="teaser__description">

					<dl>
						<dt>Ort</dt>
						<dd>{VAR:event_location:nl2br}</dd>
					</dl>

						{IF({ISSET:event_instructor:VAR})}
						<dl>
							<dt>Leitung</dt>
							<dd>{VAR:event_instructor:nl2br}</dd>
						</dl>
						{ENDIF}

						{IF({ISSET:event_remark:VAR})}
						<dl>
							<dt>Anmerkung</dt>
							<dd>{VAR:event_remark:nl2br}</dd>
						</dl>
						{ENDIF}
					</dl>

					<dl>
						<dt>Anmeldung</dt>
						<dd>
							<div class="event-availability">

								{IF("{VAR:event_needs_registration}" == "0")}
									<p>Keine Anmeldung erforderlich</p>
								{ENDIF}

								{IF("{VAR:event_seats_max}" == "0")}
									<p>Keine Teilnehmerbegrenzung</p>
								{ELSE}

									{INCLUDE:PATHTOWEBROOT.'templates/partials/availability.tpl'}

									{IF("{VAR:event_seats_taken}" != "{VAR:event_seats_max}")}
										<div class="event_seats_available">{VAR:event_seats_available} Plätze frei</div>
									{ELSE}
										Diese Veranstaltung ist ausgebucht
									{ENDIF}
								{ENDIF}
							</div>
							<p class="teaser__action-area">
								{IF( "{VAR:event_needs_registration}" && "{VAR:event_can_registrate}" )}
									<a class="subscribe more" href="{VAR:event_subscribe_url}">Anmelden</a>
								{ENDIF}
							</p>
						</dd>
					</dl>

				</div>

			</div>
		</details>

	</div>
</article>
<script type='application/ld+json'> 
{
  "@context": "http://www.schema.org",
  "@type": "Event",
  "name": "{VAR:course_title} / {VAR:event_title}",
  "url": "{SELFURL}",
  "description": "{VAR:event_remark}",
  "startDate": "{VAR:event_begin}",
  "endDate": "{VAR:event_end}",
  "location": {
	"@type": "Place",
	"name": "{VAR:event_location}",
  }
}
</script>
