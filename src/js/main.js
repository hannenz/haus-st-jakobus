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
};



document.addEventListener('DOMContentLoaded', function() {
	var app = new APP();
	app.init();
});

$(document).foundation ();
