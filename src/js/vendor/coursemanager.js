/**
 * src/js/vendor/coursemanager.js
 *
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 */
CourseManager = {

	self: null,

	init: function() {
		self = this;

		self.$courseManager = $('#course-manager');

		self.initUpdateSeatsTakenForms();
		self.initFilterByTypeForm();
		self.initExport();
	},

	setBusy: function() {
		self.$courseManager.addClass('is-busy');
	},

	setIdle: function() {
		self.$courseManager.removeClass('is-busy');
	},

	initUpdateSeatsTakenForms: function() {

		$(document).on('change', '[name=event_seats_taken]', function(ev) {
			var $form = $(this).parents('.event-seats-taken-form');
			var url = $form.attr('action');

			self.setBusy();

			$.post(url, $form.serialize(), function() {
				self.setIdle();
			});
		});
	},

	initFilterByTypeForm: function() {
		console.log('initFilterByTypeForm');

		var $filterByTypeForm = $('#filterByTypeForm');
		$filterByTypeForm.find('select').on('change', function() {

			self.setBusy();
			var url = $filterByTypeForm.attr('action');

			$.post(url, $filterByTypeForm.serialize(), function(response) {

				$('#tabs-1').replaceWith($(response).find('#tabs-1'));
				$('#tabs-2').replaceWith($(response).find('#tabs-2'));

				self.setIdle();
			});
		});
	},

	initExport: function() {

		var $exportButton = $('#exportButton');

		$exportButton.on('click', function() {

			 cmtPage.showConfirm({
				 title: 'Anmeldedaten exportieren',
				 contentContainerID: $(this).attr('data-dialog-content-id'),
				 onConfirm: function() {

					// This is a dirty hack !
					// We need to access the form inside the actual dialog
					// which is a cloned version of the one in our markup
					// I could not find a way to access it in a clean way yet...
					// For now we just assume that the dialog's form is the
					// second one in the DOM (which might ot might not be
					// reliable...)
					var $exportRangeForms = $('.exportRangeForm');
					if ($exportRangeForms.length != 2) {
						console.log("Something went wrong...");
						return;
					}

					var $exportRangeForm = $($exportRangeForms.get(1));

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
