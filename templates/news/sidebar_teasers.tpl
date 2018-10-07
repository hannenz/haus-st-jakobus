<div class="sidebar-widget">
	<h3>Weitere Neuigkeiten</h3>
	{LOOP VAR(posts)}
		{INCLUDE:PATHTOWEBROOT.'templates/news/teaser.tpl'}
	{ENDLOOP VAR}
</div>
