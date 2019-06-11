<figure>
	{IF({LAYOUTMODE})} {IMAGE:1:media} {ELSE} <img class="lazy" data-src="/media/{IMAGESRC:1}" alt="" /> {ENDIF}
	{IF ({LAYOUTMODE} == true || {ISSET:head1:CONTENT})}<figcaption>{HEAD:1:all}</figcaption>{ENDIF}
</figure>
