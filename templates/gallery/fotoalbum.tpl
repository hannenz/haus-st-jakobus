<div class="fotoalbum">
	{LOOP VAR(images)}
	<figure class="fotoalbum__image">
		<a class="foo" href="/media/gallery/{VAR:gallery_image_internal_filename}" title="{VAR:gallery_image_title}">
			<img class="thumbnail" src="/media/gallery/thumbnails/{VAR:gallery_image_internal_filename}" alt="{VAR:gallery_image_title}" />
		</a>
		{IF({ISSET:gallery_image_title})}
			<!-- <figcaption class="fotoalbum__caption">{VAR:gallery_image_title}</figcaption> -->
		{ENDIF}
	</figure>
	{ENDLOOP VAR}
</div>
