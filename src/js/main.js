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

		this.initCalendarWidget();

	};


	this.onWindowScroll = function (ev) {
		var y = window.scrollY;
		var ticking = false;

		if (!ticking) {
			window.requestAnimationFrame (function () {

				console.log (y);
				document.body.classList.toggle ('page-has-scrolled', y > 100);
		
				ticking = false;
			});
		}
	}

	this.initCalendarWidget = function() {
		console.log('initCalendarWidget');
		var links = document.querySelectorAll('.calendar-widget-link');

		links.forEach(function(el, i) {
			el.addEventListener('click', function(ev) {
				ev.preventDefault();
				var xhr = new XMLHttpRequest();
				xhr.open('GET', el.getAttribute('href'), true);
				xhr.onload = function() {
					if (xhr.status >= 200 && xhr.status < 400) {
						var data = xhr.responseText;
						console.log(data);

						var container = document.querySelector('.calendar-widget');
						self.initCalendarWidget();

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
