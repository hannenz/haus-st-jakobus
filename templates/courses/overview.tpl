<!-- <aside class="sidebar"> -->
<!-- 	<nav class="courses&#45;by&#45;category"> -->
<!-- 		<p>Nach Kategorie</p> -->
<!-- 		<ul> -->
<!-- 			{LOOP VAR(categories)} -->
<!-- 				<li> -->
<!-- 					<a href="{PAGEURL}?action=listByCategory&#38;categoryId={VAR:id}">{VAR:course_category_name}</a> -->
<!-- 				</li> -->
<!-- 			{ENDLOOP VAR} -->
<!-- 		</ul> -->
<!-- 	</nav> -->
<!-- </aside> -->
<!-- <section class="main&#45;content courses"> -->
	{LOOP VAR(courses)}
		<article class="course media-object stack-for-small">
			<figure class="course__image media-object-section">
				<img src="/media/courses/thumbnails/square/{VAR:course_image}" />
			</figure>
			<header class="course__header media-object-section">
				<h2 class="headline course__headline">{VAR:course_title}</h2>
				<h3 class="subheadline course_subheadline">{VAR:course_subheadline}</h3>
			</header>
			<!-- <div class="course__description"> -->
			<!-- 	{VAR:course_description} -->
			<!-- </div> -->

			<p> <a class="button" href="{VAR:course_detail_url}">Details</a></p>

			<!-- <footer class="course__footer"> -->
			<!-- 	{IF({ISSET:course_elements})} -->
			<!-- 		<dl class="course__detail"> -->
			<!-- 			<dt>Elemente</dt> -->
			<!-- 			<dd>{VAR:course_elements}</dd> -->
			<!-- 		</dl> -->
			<!-- 	{ENDIF} -->
			<!-- 	<dl class="course__detail"> -->
			<!-- 		<dt>Leitung</dt> -->
			<!-- 		<dd>{VAR:course_instructor}</dd> -->
			<!-- 	</dl> -->
			<!-- 	</dl> -->
			<!-- 	{LOOP VAR(course_events)} -->
			<!-- 		<dl class="course__detail event"> -->
			<!-- 			<dt class="event__title">{VAR:media_title}</dt> -->
			<!-- 			<dd class="event__date">{VAR:event_begin_fmt} &#38;ndash; {VAR:event_end_fmt}</dd> -->
			<!-- 		</dl> -->
			<!-- 	{ENDLOOP VAR} -->
            <!--  -->
			<!-- </footer> -->
		</article>
	{ENDLOOP VAR}
<!-- </section> -->
