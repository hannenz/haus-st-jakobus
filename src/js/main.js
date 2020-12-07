/**
 * src/js/main.js
 *
 * Main javascript file
 *
 * @author Johannes Braun <johannes.braun@hannenz.de>
 * @package haus-st-jakobus
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

		this.initLazyLoading();
		this.initHomepageSlider();
		this.initCalendarWidget();
		this.initWidgets();

		// Lazy init map
		if ('IntersectionObserver' in window) {
			var observer = new IntersectionObserver(function(entries){
				if (entries[0].intersectionRatio > 0) {
					self.initMap();
				}
			});
			observer.observe(document.getElementById('map'));
		}
		else {
			self.initMap();
		}

		// Init brightbox on galleries (fotoalbum)
		if ($('.fotoalbum a').length > 0) {
			$('.fotoalbum a').brightbox();
		}

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

		var mapCenterPos = [9.82074, 48.32681];
		var pinPos = [9.82624, 48.29870];

		mapboxgl.accessToken = 'pk.eyJ1IjoiaGFubmVueiIsImEiOiJPMktpVm1BIn0.qMq_8uPobOFc-eBXIFVtog';
		var map = new mapboxgl.Map({
			container: document.getElementById('map'),
			style: 'mapbox://styles/mapbox/outdoors-v11',
			center: mapCenterPos,
			zoom: 11,
			scrollZoom: false
		});
		map.on('load', function() {
			// Load the GeoJSON track to display ("the Jakobsweg")
			// Since the track is quite large we load it via AJAX
			var req = new XMLHttpRequest();
			req.open('GET', '/dist/js/vendor/track.geo.json');
			req.responseType = 'json';
			req.onload = function() {

				var data = req.response;
				console.log(data);

				map.addSource('route', {
					'type': 'geojson',
					'data': data.features[0]
				});
				map.addLayer({
					'id': 'route',
					'type': 'line',
					'source': 'route',
					'layout': {
						'line-join': 'round',
						'line-cap': 'round'
					},
					'paint': {
						'line-color': '#af1e23',
						'line-width': 5
					}
				});
			};
			req.send();
		});


		var nav = new mapboxgl.NavigationControl();
		map.addControl(nav, 'bottom-left');

		var markerEl = document.createElement('div');
		markerEl.className = 'marker';
		markerEl.style.backgroundImage = 'url(/dist/img/shell-icon.png)';
		markerEl.style.width = '50px';
		markerEl.style.height = '82px';

		var marker = new mapboxgl.Marker({
				'element': markerEl,
				'anchor': 'bottom'
			})
			.setLngLat(pinPos)
			.addTo(map)
		;
	};


	this.initLazyLoading = function() {
		var lazyLoader = new LazyLoad({
			use_polyfill: false,
			use_native: true,
			elements_selector: '.lazy'
		});
	}
};



document.addEventListener('DOMContentLoaded', function() {
	var app = new APP();
	app.init();
});

$(document).foundation ();
