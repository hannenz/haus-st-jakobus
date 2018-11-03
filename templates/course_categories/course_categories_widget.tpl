<nav class="widget courses-by-category">
	<p>Kurse</p>
	<ul>
		{LOOP VAR(course_categories)}
			<li>
				<a href="{VAR:course_overview_url}?action=listByCategory&categoryId={VAR:id}">{VAR:course_category_name}</a>
			</li>
		{ENDLOOP VAR}
	</ul>
</nav>

