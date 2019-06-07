<div class="widget calendar-widget">
	<div class="widget__header calendar-widget__header">
		<a class="calendar-widet__prev calendar-widget__link" href="{VAR:baseUrl}?year={VAR:prevYear}&month={VAR:prevMonth}">«</a>
		<div class="calendar-widget__month">{VAR:month}</div>
		<a class="calendar-widget__next calendar-widget__link" href="{VAR:baseUrl}?year={VAR:nextYear}&month={VAR:nextMonth}">»</a>
	</div>
	<div class="widget__body">
		{VAR:calendarContent}
	</div>
</div>
