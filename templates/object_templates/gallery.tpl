{IF({LAYOUTMODE})} 
	<div>
		<figure>
			{IMAGE:1:media/gallery}
			<figcaption>{TEXT:1}</figcaption>
		</figure>
	</div>
	<div>
		<figure>
			{IMAGE:2:media/gallery}
			<figcaption>{TEXT:2}</figcaption>
		</figure>
	</div>
	<div>
		<figure>
			{IMAGE:3:media/gallery}
			<figcaption>{TEXT:3}</figcaption>
		</figure>
	</div>
	<div>
		<figure>
			{IMAGE:4:media/gallery}
			<figcaption>{TEXT:4}</figcaption>
		</figure>
	</div>
	<div>
		<figure>
			{IMAGE:5:media/gallery}
			<figcaption>{TEXT:5}</figcaption>
		</figure>
	</div>
{ELSE}
<div class="orbit" data-orbit data-no-options="animInFromLeft:fade-in;animInFromRight:fade-in;animOutToLeft:fade-out;animOutToRight:fade-out">
	<div class="orbit-wrapper">
		<div class="orbit-controls">
			<button class="orbit-previous">Vorheriges Bild&#9664;&#xFE0E;</button>
			<button class="orbit-next">Nächstes Bild&#9654;&#xFE0E;</button>
		</div>
		<ul class="orbit-container">
			{IF({ISSET:image1:CONTENT})}
				<li class="orbit-slide is-active">
					<figure class="orbit-figure">
						<img class="orbit-image" src="{IMAGESRC:1}" alt="{TEXT:1}" />
						{IF({ISSET:text1:CONTENT})}<figcaption class="orbit-caption">{TEXT:1}</figcaption>{ENDIF}
					</figure>
				</li>
			{ENDIF}
			{IF({ISSET:image2:CONTENT})}
				<li class="orbit-slide">
					<figure class="orbit-figure">
						<img class="orbit-image" src="{IMAGESRC:2}" alt="{TEXT:2}" />
						{IF({ISSET:text2:CONTENT})}<figcaption class="orbit-caption">{TEXT:2}</figcaption>{ENDIF}
					</figure>
				</li>
			{ENDIF}
			{IF({ISSET:image3:CONTENT})}
				<li class="orbit-slide">
					<figure class="orbit-figure">
						<img class="orbit-image" src="{IMAGESRC:3}" alt="{TEXT:3}" />
						{IF({ISSET:text3:CONTENT})}<figcaption class="orbit-caption">{TEXT:3}</figcaption>{ENDIF}
					</figure>
				</li>
			{ENDIF}
			{IF({ISSET:image4:CONTENT})}
				<li class="orbit-slide">
					<figure class="orbit-figure">
						<img class="orbit-image" src="{IMAGESRC:4}" alt="{TEXT:4}" />
						{IF({ISSET:text4:CONTENT})}<figcaption class="orbit-caption">{TEXT:4}</figcaption>{ENDIF}
					</figure>
				</li>
			{ENDIF}
			{IF({ISSET:image5:CONTENT})}
				<li class="orbit-slide">
					<figure class="orbit-figure">
						<img class="orbit-image" src="{IMAGESRC:5}" alt="{TEXT:5}" />
						{IF({ISSET:text5:CONTENT})}<figcaption class="orbit-caption">{TEXT:5}</figcaption>{ENDIF}
					</figure>
				</li>
			{ENDIF}
		</ul>
	</div>
</div>
{ENDIF}
