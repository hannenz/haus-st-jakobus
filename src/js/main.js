/**
 * src/js/main.js
 *
 * main javascript file
 */

function APP () {

	var self = this;

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

		// this.initThrottleResize();

		// Lazy loadiong images
		// this.bLazy = new Blazy({
		// 	selector: '.lazy',
		// 	offset: 100,
		// 	successClass: 'lazy--loaded',
		// 	errorClass: 'lazy--failed',
		// 	error: function(el) {
		// 	 	el.src = '/img/noimage.svg';
		// 	}
		// });
        //
		var $secnav = $('.secnav');
		console.log ($secnav);
		var options = {
			threshold: 50,
			offset: 100,
			activeClass: 'menu__link--is-active'
		};
		var elem = new Foundation.Magellan ($secnav, options);
	};
};

document.addEventListener('DOMContentLoaded', function() {

	var app = new APP();
	app.init();

});

