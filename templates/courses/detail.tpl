<article class="course">
	{IF({ISSET:templates:VAR})}
		{LOOP VAR(templates)}
			{VAR:cmt_source}
			{NEXTTEMPLATE}
		{ENDLOOP VAR}
	{ELSE}
		<header class="course__header">
			<h2 class="headline course__headline">{VAR:course_title}</h2>
			{IF({ISSET:course_subheadline})}<h3 class="subheadline course_subheadline">{VAR:course_subheadline}</h3>{ENDIF}
		</header>
		<div class="course__description">
			{VAR:course_description}
		</div>


		{IF({ISSET:images})}
		<ul class="course__images">
			{LOOP VAR(images)}
				<li class="course-image">

					<figure class="course-image__inner">
						<div class="course-image__wrapper">
							<img class="course-image__image" src="/media/courses/{VAR:media_image_file_internal}" alt="" />
						</div>
						{IF({ISSET:media_title:VAR})}
							<figcaption class="course-image__caption">{VAR:media_title}</figcaption>
						{ENDIF}
					</figure>

				</li>
			{ENDLOOP VAR}
		</ul>
		{ENDIF}



		<footer class="course__footer">

			{IF({ISSET:course_elements})}
			<dl class="course__detail">
				<dt>Elemente</dt>
				<dd>{VAR:course_elements}</dd>
			</dl>
			{ENDIF}

			<dl class="course__detail">
				{IF({ISSET:course_costs_fmt})}
					<div class="course_costs">{VAR:course_costs_fmt}</div>
				{ENDIF}
			</dl>


			{IF({ISSET:documents})}
			<ul class="course__documents">
				{LOOP VAR(documents)}
					<li class="course-document">
						<svg class="icon icon-file-pdf" viewBox="0 0 32 32">
							<!-- <path d="M26.313 18.421c&#45;0.427&#45;0.42&#45;1.372&#45;0.643&#45;2.812&#45;0.662&#45;0.974&#45;0.011&#45;2.147 0.075&#45;3.38 0.248&#45;0.552&#45;0.319&#45;1.122&#45;0.665&#45;1.568&#45;1.083&#45;1.202&#45;1.122&#45;2.205&#45;2.68&#45;2.831&#45;4.394 0.041&#45;0.16 0.075&#45;0.301 0.108&#45;0.444 0 0 0.677&#45;3.846 0.498&#45;5.146&#45;0.025&#45;0.178&#45;0.040&#45;0.23&#45;0.088&#45;0.369l&#45;0.059&#45;0.151c&#45;0.184&#45;0.425&#45;0.545&#45;0.875&#45;1.111&#45;0.85l&#45;0.341&#45;0.011c&#45;0.631 0&#45;1.146 0.323&#45;1.281 0.805&#45;0.411 1.514 0.013 3.778 0.781 6.711l&#45;0.197 0.478c&#45;0.55 1.34&#45;1.238 2.689&#45;1.846 3.88l&#45;0.079 0.155c&#45;0.639 1.251&#45;1.22 2.313&#45;1.745 3.213l&#45;0.543 0.287c&#45;0.040 0.021&#45;0.97 0.513&#45;1.188 0.645&#45;1.852 1.106&#45;3.079 2.361&#45;3.282 3.357&#45;0.065 0.318&#45;0.017 0.725 0.313 0.913l0.525 0.264c0.228 0.114 0.468 0.172 0.714 0.172 1.319 0 2.85&#45;1.643 4.959&#45;5.324 2.435&#45;0.793 5.208&#45;1.452 7.638&#45;1.815 1.852 1.043 4.129 1.767 5.567 1.767 0.255 0 0.475&#45;0.024 0.654&#45;0.072 0.276&#45;0.073 0.508&#45;0.23 0.65&#45;0.444 0.279&#45;0.42 0.335&#45;0.998 0.26&#45;1.59&#45;0.023&#45;0.176&#45;0.163&#45;0.393&#45;0.315&#45;0.541zM6.614 25.439c0.241&#45;0.658 1.192&#45;1.958 2.6&#45;3.111 0.088&#45;0.072 0.306&#45;0.276 0.506&#45;0.466&#45;1.472 2.348&#45;2.458 3.283&#45;3.106 3.577zM14.951 6.24c0.424 0 0.665 1.069 0.685 2.070s&#45;0.214 1.705&#45;0.505 2.225c&#45;0.241&#45;0.77&#45;0.357&#45;1.984&#45;0.357&#45;2.778 0 0&#45;0.018&#45;1.517 0.177&#45;1.517v0zM12.464 19.922c0.295&#45;0.529 0.603&#45;1.086 0.917&#45;1.677 0.765&#45;1.447 1.249&#45;2.58 1.609&#45;3.511 0.716 1.303 1.608 2.41 2.656 3.297 0.131 0.111 0.269 0.222 0.415 0.333&#45;2.132 0.422&#45;3.974 0.935&#45;5.596 1.558v0zM25.903 19.802c&#45;0.13 0.081&#45;0.502 0.128&#45;0.741 0.128&#45;0.772 0&#45;1.727&#45;0.353&#45;3.066&#45;0.927 0.515&#45;0.038 0.986&#45;0.057 1.409&#45;0.057 0.774 0 1.004&#45;0.003 1.761 0.19s0.767 0.585 0.637 0.667v0z"></path> -->
							<path d="M28.681 7.159c-0.694-0.947-1.662-2.053-2.724-3.116s-2.169-2.030-3.116-2.724c-1.612-1.182-2.393-1.319-2.841-1.319h-15.5c-1.378 0-2.5 1.121-2.5 2.5v27c0 1.378 1.121 2.5 2.5 2.5h23c1.378 0 2.5-1.122 2.5-2.5v-19.5c0-0.448-0.137-1.23-1.319-2.841v0zM24.543 5.457c0.959 0.959 1.712 1.825 2.268 2.543h-4.811v-4.811c0.718 0.556 1.584 1.309 2.543 2.268v0zM28 29.5c0 0.271-0.229 0.5-0.5 0.5h-23c-0.271 0-0.5-0.229-0.5-0.5v-27c0-0.271 0.229-0.5 0.5-0.5 0 0 15.499-0 15.5 0v7c0 0.552 0.448 1 1 1h7v19.5z"></path>
							<rect x="0" y="18" width="24" height="10" fill="#c00000" />
							<text x="3" y="26" stroke="#ffffff">{VAR:media_document_file_extension:strtoupper}</text>
						</svg>

						<div class="course-document__wrapper">
							<a href="/media/courses/{VAR:media_document_file_internal}" target="_blank">{VAR:media_document_file}</a>
							{IF({ISSET:media_title})}
							<p class="course-document__description">{VAR:media_title}</p>
							{ENDIF}
						</div>
					</li>
				{ENDLOOP VAR}
			</ul>
			{ENDIF}



			{IF("{COUNT:course_events}" != "0")}

				<h3 class="headline">Termine</h3>

				{LOOP VAR(course_events)}
					{INCLUDE:PATHTOWEBROOT."templates/events/teaser.tpl"}
				{ENDLOOP VAR}
			{ENDIF}

			<a href="{VAR:course_overview_url}" class="back">Zurück</a>
		</footer>
	{ENDIF}
</article>
