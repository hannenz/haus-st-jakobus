/**
 * src/js/main.js
 *
 * main javascript file
 */

function APP () {

	var self = this;
	var headerHeight = 0;

	self.debug = true;



	this.init = function() {

		if (this.debug) {
			console.log('APP::init');
		}

		this.pageInit();
	};



	this.pageInit = function() {

		if (this.debug) {
			console.log('APP::pageInit');
		}

		document.body.classList.add('page-has-loaded');

		this.main();
	};



	this.main = function() {
		var header = document.querySelector ('.main-header');
		var rect = header.getBoundingClientRect ();
		self.headerHeight = rect.height;
		window.addEventListener ('scroll', self.onWindowScroll);

		this.initHomepageSlider();
		this.initCalendarWidget();
		this.initWidgets();
		this.initMap();

		if (document.getElementById('pilgrimpass-form')) {
			this.initPilgrimpassForm();
		}
	};

	this.initHomepageSlider = function() {

		var $homepageSlider = $('.homepage-slider');
		if ($homepageSlider.length == 1) {
			self.HomepageSlider = new Foundation.Orbit($homepageSlider, {
				autoPlay: true,
				timerDelay: 6000,
				animInFromLeft: 'fade-in',
				animInFromRight: 'fade-in',
				animOutToLeft: 'fade-out',
				animOutToRight: 'fade-out',
				containerClass: 'homepage-slider__container',
				slideClass: 'homepage-slider__slide'
			});
		}
	};


	this.onWindowScroll = function (ev) {
		var y = window.scrollY;
		var ticking = false;

		if (!ticking) {
			window.requestAnimationFrame (function () {

				document.body.classList.toggle ('page-has-scrolled', y > 100);

				ticking = false;
			});
		}
	}


	this.initCalendarWidget = function() {

		console.log('initCalendarWidget');

		var links = document.querySelectorAll('.calendar-widget__link');

		links.forEach(function(el, i) {

			el.addEventListener('click', function(ev) {
				ev.preventDefault();

				var url = el.getAttribute('href');

				var xhr = new XMLHttpRequest();
				xhr.open('GET', url, true);

				xhr.onload = function() {

					if (xhr.readyState == 4) {
						if (xhr.status >= 200 && xhr.status < 400) {
							var container = document.querySelector('.calendar-widget-container');
							container.innerHTML = xhr.responseText;
							self.initCalendarWidget();
						}
					}
				};

				xhr.send();

				return false;
			});
		});
	}

	this.initPilgrimpassForm = function() {
		var addBtn = document.getElementById('add-button');
		var fs = document.querySelector('.fieldset');
		var container = document.getElementById('form-container');
		var countInput = document.getElementById('count');

		if (addBtn) {
			addBtn.addEventListener('click', function(event) {
				event.preventDefault();
				var newfs = fs.cloneNode(true);
				container.appendChild(newfs);
				var rmBtn = newfs.querySelector('.remove-button');
				countInput.value = container.children.length;
				rmBtn.addEventListener('click', onRemoveButtonClicked);
				var inputs = newfs.querySelectorAll('input');
				for (var i = 0; i < inputs.length; i++) {
					inputs[i].value = '';
					var parts= inputs[i].id.match(/(.*)-(\d+)$/);
					if (parts) {
						var newId = parts[1] + '-' + (parseInt(parts[2]) + 1);
						var label = newfs.querySelector('[for=' + inputs[i].id + ']');
						inputs[i].id = newId;
						label.setAttribute('for', newId);
					}
				}
				var selects = newfs.querySelectorAll('select');
				for (var i = 0; i < selects.length; i++) {
					selects[i].selectedIndex = null;
				}
			});
		}

		var removeButtons = document.querySelectorAll('.remove-button');
		for (var i = 0; i < removeButtons.length; i++) {
			removeButtons[i].addEventListener('click', onRemoveButtonClicked);
		}

		function onRemoveButtonClicked(event) {
			event.preventDefault();

			if (confirm("Sind Sie sicher, dass Sie diesen Pilgerausweis entfernen möchten?")) {
				this.parentNode.parentNode.removeChild(this.parentNode);
				countInput.value = container.children.length;
			}
			return false;
		}


		var paymentAmountCustom = document.getElementById('payment-amount-custom');
		if (paymentAmountCustom) {
			paymentAmountCustom.addEventListener("change", function() {
				if (this.value == 'custom') {
					document.getElementById('payment-amount-custom-text').focus();
				}
			});
			
		}

		var abortBtn = document.querySelectorAll('.pilgrimpass-abort');
		for (i = 0; i < abortBtn.length; i++) {
			abortBtn[i].addEventListener('click', function(ev) {
				var r = window.confirm(this.dataset.confirmText);
				if (!r) {
					ev.preventDefault();
					return false;
				}
			});
		}
	};

	this.initWidgets = function() {
		var widgets = document.querySelectorAll('.widget');

		for (var i = 0; i < widgets.length; i++) {
			var widget = widgets[i];
			var header = widget.querySelector('.widget__header');
			header.addEventListener('click', function(ev) {
				this.parentNode.querySelector('.widget__body').classList.toggle('is-hidden');

			});
		}
	};

	this.initMap = function() {
		var mapOptions = {
			zoomControl: true,
			scrollWheelZoom: false,
			touchZoom: false,
			dragging: false
		};

		var mapElement = document.getElementById('map');

		var map = L.map(mapElement, mapOptions).setView([48.29870,9.82624], 12);
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiaGFubmVueiIsImEiOiJPMktpVm1BIn0.qMq_8uPobOFc-eBXIFVtog', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			maxZoom: 18,
			minZoom: 7,
			id: 'mapbox.outdoors',
			accessToken: 'pk.eyJ1IjoiaGFubmVueiIsImEiOiJPMktpVm1BIn0.qMq_8uPobOFc-eBXIFVtog'
		}).addTo(map);

		var shellIcon = L.icon({
			iconUrl: '/dist/img/logo.png',
			iconSize: [32, 32]
		});
		var marker = L.marker([48.29870,9.82624]/*, {icon: shellIcon}i*/).addTo(map);

		// Load the GeoJSON track to display ("the Jakobsweg")
		// Since the track is quite large we load it via AJAX
		var req = new XMLHttpRequest();
		req.open('GET', '/dist/js/track.geo.json');
		req.responseType = 'json';
		req.onload = function() {
			var trackStyle = {
				"color": "#af1e23",
				"weight": 5,
				"opacity": 0.6
			}
			L.geoJSON(req.response, {style: trackStyle}).addTo(map);
		};
		req.send();

		// Enable interaction only when focused (e.g. clicked inside)
		mapElement.addEventListener('focus', function() {
			map.scrollWheelZoom.enable();
			map.touchZoom.enable();
			map.dragging.enable();
		});
		mapElement.addEventListener('blur', function() {
			map.scrollWheelZoom.disable();
			map.touchZoom.disable();
			map.dragging.disable();
		});
	};
};



document.addEventListener('DOMContentLoaded', function() {
	var app = new APP();
	app.init();
});

$(document).foundation ();
