<div class="homepage-slider" data-orbit>
	<div class="homepage-slider__container">

		{LOOP VAR(images)}
			<div class="homepage-slider__slide">
				<figure class="homepage-slider__figure">
					<img class="homepage-slider__image" src="/media/gallery/{VAR:gallery_image_internal_filename}" alt="" />
					<figcaption class="homepage-slider__caption">
						<span class="homepage-slider__caption-inner"> {VAR:gallery_image_title} </span>
					</figcaption>

				</figure>
			</div>
		{ENDLOOP VAR}

	</div>
</div>
