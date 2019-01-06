<div class="columns">
	<div class="column">
		{IF({LAYOUTMODE} || {ISSET:head1:CONTENT})}<h2 class="headline">{HEAD:1}</h2>{ENDIF}
		{IF({LAYOUTMODE} || {ISSET:text1:CONTENT})}<p class="body-copy">{TEXT:1}</h2>{ENDIF}
		{IF({LAYOUTMODE} || {ISSET:image1:CONTENT})}
			<figure>
				{IMAGE:1:media}
				{IF({LAYOUTMODE} || {ISSET:head3})}
					<figcaption>{HEAD:3}</figcaption>
				{ENDIF}
			</figure>
		{ENDIF}
	</div>
	<div class="column">
		{IF({LAYOUTMODE} || {ISSET:head2:CONTENT})}<h2 class="headline">{HEAD:2}</h2>{ENDIF}
		{IF({LAYOUTMODE} || {ISSET:text2:CONTENT})}<p class="body-copy">{TEXT:2}</h2>{ENDIF}
		{IF({LAYOUTMODE} || {ISSET:image2:CONTENT})}
			<figure>
				{IMAGE:2:media}
				{IF({LAYOUTMODE} || {ISSET:head4})}
					<figcaption>{HEAD:4}</figcaption>
				{ENDIF}
			</figure>
		{ENDIF}
	</div>
</div>
