<figure class="floated-image floated-image--right floated-image--small">
	<figure class="floated-image__image">
		{IMAGE:1:media}
		{IF({LAYOUTMODE} || {ISSET:head1:CONTENT})}
			<figcaption>{HEAD:1}</figcaption>
		{ENDIF}
	</figure>
	<div class="floated-image__text">
		{TEXT:1}
	</div>
</figure>
