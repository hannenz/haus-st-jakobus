/**
 * src/js/vendor/coursemanager.js
 *
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
 */
CourseManager = {

	self: null,

	init: function() {
		jQuery(document).ready(this.setup.bind(this));
	},

	setup: function() {
		self = this;

		self.$courseManager = jQuery('#course-manager');

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

		jQuery(document).on('change', '[name=event_seats_taken]', function(ev) {
			var $form = jQuery(this).parents('.event-seats-taken-form');
			self.updateSeatsTaken($form);
			return false;
		});

		jQuery(document).on('submit', '.event-seats-taken-form', function(ev) {
			var $form = jQuery(this);
			self.updateSeatsTaken($form);

			ev.preventDefault();
			return false;
		});
	},

	updateSeatsTaken: function($form) {
		self.setBusy();
		$.post($form.attr('action'), $form.serialize(), function(response) {
			var r = JSON.parse(response);
			jQuery('[name=event_seats_taken]').val(r.event_seats_taken);
			if (!r.success) {
				$form.css('outline', '2px solid #c00000');
				alert("Speichern fehlgeschlagen!");
			}

			self.setIdle();
		});
	},

	initFilterByTypeForm: function() {

		var $filterByTypeForm = jQuery('#filterByTypeForm');
		$filterByTypeForm.find('select').on('change', function() {

			self.setBusy();
			var url = $filterByTypeForm.attr('action');

			$.post(url, $filterByTypeForm.serialize(), function(response) {

				jQuery('#tabs-1').replaceWith(jQuery(response).find('#tabs-1'));
				jQuery('#tabs-2').replaceWith(jQuery(response).find('#tabs-2'));

				self.setIdle();
			});
		});
	},

	initExport: function() {

		var $exportButton = jQuery('#exportButton');

		$exportButton.on('click', function() {
			var dialogId = jQuery(this).attr('data-dialog-content-id');
			var $dialogEl = jQuery('#' + dialogId);

			var dialog = $dialogEl.dialog({
				resizable: false,
				title: $dialogEl.attr('title'),
				modal: true,
				width: 360,
				dialogClass: 'cmtDialogTypeConfirm',
			});
			jQuery('.cmtButtonBack', dialog).on('click', function(ev) {
				jQuery(dialog).dialog('close');
				ev.preventDefault();
				return false;
			});
			jQuery('.cmtButtonSave', dialog).on('click', function(ev) {

			});
		});
	}
}

CourseManager.init();
