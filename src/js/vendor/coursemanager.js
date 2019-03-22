
CourseManager = {


	init: function() {

		var $courseManager = $('#course-manager');
		$(document).on('change', '[name=event_seats_taken]', function(ev) {
			var $form = $(this).parents('.event-seats-taken-form');
			var url = $form.attr('action');
			$courseManager.addClass('is-busy');
			$.post(url, $form.serialize(), function() {
				$courseManager.removeClass('is-busy');
			});
		});

		var $filterByTypeForm = $('#filterByTypeForm');
		$filterByTypeForm.find('select').on('change', function() {
			var url = $filterByTypeForm.attr('action');
			$courseManager.addClass('is-busy');
			$.post(url, $filterByTypeForm.serialize(), function(response) {
				$('#tabs-1').replaceWith($(response).find('#tabs-1'));
				$('#tabs-2').replaceWith($(response).find('#tabs-2'));
				$courseManager.removeClass('is-busy');
			});
		});

		var $exportButton = $('#exportButton');

		$exportButton.on('click', function() {

			 cmtPage.showConfirm({
				 title: 'Export',
				 contentContainerID: $(this).attr('data-dialog-content-id'),
				 onConfirm: function() {

					var $exportRangeForm = $(this).find('#exportRangeForm');

					 $.post($exportRangeForm.attr('action'), $exportRangeForm.serialize(), function(response){
						 console.log(response);
					 });

				 }
			});
		});
	}
}

$(function() {

	CourseManager.init();
	
});
