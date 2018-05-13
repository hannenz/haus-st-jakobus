<nav class="widget courses-by-category">
	<p>Nach Kategorie</p>
	<ul>
		{LOOP VAR(course_categories)}
			<li>
				<a href="{PAGEURL}?action=listByCategory&categoryId={VAR:id}">{VAR:course_category_name}</a>
			</li>
		{ENDLOOP VAR}
	</ul>
</nav>

