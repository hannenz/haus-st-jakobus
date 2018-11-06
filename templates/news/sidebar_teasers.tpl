{EVAL}
if (preg_match('/,(\d+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
}
{ENDEVAL}
<div class="sidebar-widget">
	<!-- <h3>Weitere Neuigkeiten</h3> -->
	{LOOP VAR(posts)}
		{IF("{VAR:id}" != "{USERVAR:currentPostId}")}
			{INCLUDE:PATHTOWEBROOT.'templates/news/teaser.tpl'}
		{ENDIF}
	{ENDLOOP VAR}
</div>
