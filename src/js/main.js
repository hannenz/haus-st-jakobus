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
							var data = xhr.responseText;
							var divNode = document.createElement('div');
							divNode.innerHTML = xhr.responseText;
							var widgetNode = divNode.querySelector('.calendar-widget');
							console.log(widgetNode);

							var container = document.querySelector('.calendar-widget').parentNode;
							container.innerHTML = '';
							container.appendChild(widgetNode);

							self.initCalendarWidget();
						}
					}
				};

				xhr.send();

				return false;
			});
		});
	}
};



document.addEventListener('DOMContentLoaded', function() {
	var app = new APP();
	app.init();
});

$(document).foundation ();
