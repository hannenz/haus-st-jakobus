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
{EVAL}
/* TODO: Make sure that no empty images in between and only render anything if at least 1 image is presenty */
{ENDEVAL}
<div class="slideshow orbit" data-orbit data-no-options="animInFromLeft:fade-in;animInFromRight:fade-in;animOutToLeft:fade-out;animOutToRight:fade-out">
	<div class="orbit-wrapper">
		<div class="orbit-controls">
			<button class="orbit-previous"><svg width="100" height="100" viewBox="0 0 100 100"><path fill="#c00000" d="M20,50 80,90 80,10Z"></svg></button>
			<button class="orbit-next"><svg width="100" height="100" viewBox="0 0 100 100"><path fill="#c00000" d="M20,10 80,50 20,90Z"></svg></button>
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
	<nav class="orbit-bullets">
		<button class="is-active" data-slide="0"><span>1</span><span>C</span></button>
		{IF({ISSET:image2:CONTENT})}<button data-slide="1"><span>2</span></button>{ENDIF}
		{IF({ISSET:image3:CONTENT})}<button data-slide="2"><span>3</span></button>{ENDIF}
		{IF({ISSET:image4:CONTENT})}<button data-slide="3"><span>4</span></button>{ENDIF}
		{IF({ISSET:image5:CONTENT})}<button data-slide="4"><span>5</span></button>{ENDIF}
	</nav>
</div>
{ENDIF}
