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
		</header>

		<div class="teaser__description">
			<div>{VAR:event_time_fmt} Uhr<br>{VAR:event_location:nl2br}</div>
			<div>{VAR:event_remark}</div>
			<dl>
				<dt>Leitung</dt>
				<dd>{VAR:event_instructor:nl2br}</dd>
			</dl>
		</div>

		<div class="event-availability">

			{IF("{VAR:event_needs_registration}" == "0")}
				<p>Keine Anmeldung erforderlich</p>
			{ELSE}
				{IF("{VAR:event_seats_max}" == "0")}
					<p>Keine Teilnehmerbegrenzung</p>
				{ELSE}
					{INCLUDE:PATHTOWEBROOT.'templates/partials/availability_indicator.tpl'}
					{IF("{VAR:event_seats_taken}" != "{VAR:event_seats_max}")}
						<div class="event_seats_available">{VAR:event_seats_available} Plätze frei</div>
					{ELSE}
						Diese Veranstaltung ist ausgebucht
					{ENDIF}
				{ENDIF}
			{ENDIF}

		</div>

		<p class="teaser__action-area">
			{IF("{VAR:event_needs_registration}" == "1")}
				{IF(1 || "{VAR:event_can_registrate}" == "1")}
					<a class="subscribe more" href="{VAR:event_subscribe_url}">Anmelden</a>
				{ENDIF}
			{ENDIF}
		</p>
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
