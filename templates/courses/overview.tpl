{LOOP VAR(categories)}
	<h2 class="headline headline--section-title no-headline--large">{VAR:course_category_name}</h2>
	{LOOP VAR(Courses)}
		{INCLUDE:PATHTOWEBROOT."templates/courses/teaser.tpl"}
	{ENDLOOP VAR}
{ENDLOOP VAR}
