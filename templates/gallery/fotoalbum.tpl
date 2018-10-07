<div class="fotoalbum">
	{LOOP VAR(images)}
	<figure class="fotoalbum__image">
		<img class="thumbnail" src="/media/gallery/thumbnails/{VAR:gallery_image_internal_filename}" alt="" />
		{IF({ISSET:gallery_image_title})}
			<figcaption class="fotoalbum__caption">{VAR:gallery_image_title}</figcaption>
		{ENDIF}
	</figure>
	{ENDLOOP VAR}
</div>
