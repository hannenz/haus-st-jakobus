<blockquote class="blockquote">
	<div>{TEXT:1:char}</div>

	{IF({LAYOUTMODE} || {ISSET:head1:CONTENT})}
		<footer class="blockquote__footer">
			<cite class="blockquote__author">{HEAD:1}</cite>
		</footer>
	{ENDIF}
</blockquote>
