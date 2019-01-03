<div class="widget courses-by-category">
	<div class="widget__header">
		<h3 class="widget__title">Kurse</h3>
	</div>
	<div class="widget__body">
		<ul class="menu">
			{LOOP VAR(course_categories)}
				<li class="menu__item">
					<a href="{VAR:course_overview_url}?action=listByCategory&categoryId={VAR:id}">{VAR:course_category_name}</a>
				</li>
			{ENDLOOP VAR}
		</ul>
	</div>
</div>

