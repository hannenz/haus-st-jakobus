/**
 * Default gulpfile for HALMA projects
 *
 * Version 2019-03-27
 *
 * @see https://www.sitepoint.com/introduction-gulp-js/
 * @see https://nystudio107.com/blog/a-gulp-workflow-for-frontend-development-automation
 * @see https://nystudio107.com/blog/a-better-package-json-for-the-frontend
 */
'use strict';

// package vars
const pkg = require('./package.json');

// gulp
const gulp = require('gulp');
const {series} = require('gulp');

// Load all plugins in 'devDependencies' into the variable $
const $ = require('gulp-load-plugins')({
	pattern: ['*'],
	scope: ['devDependencies'],
	rename: {
		'gulp-strip-debug': 'stripdebug'
	}
});

// Default error handler: Log to console
const onError = (err) => {
	console.log(err);
};

// A banner to output as header for dist files
const banner = [
	"/**",
	" * @project       <%= pkg.name %>",
	" * @author        <%= pkg.author %>",
	" * @build         " + $.moment().format("llll") + " ET",
	" * @release       " + $.gitRevSync.long() + " [" + $.gitRevSync.branch() + "]",
	" * @copyright     Copyright (c) " + $.moment().format("YYYY") + ", <%= pkg.copyright %>",
	" *",
	" */",
	""
].join("\n");


var svgoOptions = {
	plugins: [
		{ cleanupIDs: false },
		{ mergePaths: false },
		{ removeViewBox: false },
		{ convertStyleToAttrs: false },
		{ removeUnknownsAndDefaults: false },
		{ cleanupAttrs: false }
	]
};

// Project settings
var settings = {

	browserSync: {
		proxy:'https://' + pkg.name + '.localhost',
		open: false,	// Don't open browser, change to "local" if you want or see https://browsersync.io/docs/options#option-open
		notify: false,	// Don't notify on every change
		https: {
			key: require('os').homedir() + '/server.key',
			cert: require('os').homedir() + '/server.crt'
			// key: '/etc/ssl/private/ssl-cert-snakeoil.key',
			// cert: '/etc/ssl/certs/ssl-cert-snakeoil.pem'
		}
	},

	css: {
		src: './src/css/**/*.scss',
		dest: pkg.project_settings.prefix + 'css/',
		srcMain: [
			'./src/css/main.scss',
			'./src/css/coursemanager.scss'
		],
		options: {
			sass: {
				outputStyle: 'compact',
				precision: 3,
				errLogToConsole: true,
				includePaths: [
					'node_modules/foundation-sites/scss',
					'node_modules/motion-ui/src',
					$.bourbon.includePaths
				]
			},

			sassProduction: {
				outputStyle: 'compressed',
				precision: 3,
				errLogToConsole: true,
				includePaths: [
					'node_modules/foundation-sites/scss',
					'node_modules/motion-ui/src',
					$.bourbon.includePaths
				]
			}
		}
	},

	js: {
		src:	'./src/js/*.js',
		dest:	pkg.project_settings.prefix + 'js/',
		destFile:	'main.min.js'
	},

	jsVendor: {
		src: [
			'./src/js/vendor/**/*.js',
				'./src/js/vendor/track.geo.json',
				'./node_modules/foundation-sites/dist/js/**/*.js',
				'./node_modules/jquery/dist/jquery.min.js',
				'./node_modules/jquery.appendgrid/jquery.appendGrid-1.7.1.min.js',
				'./node_modules/leaflet/dist/leaflet.js',
				'./node_modules/vanilla-lazyload/dist/lazyload.min.js'
		],
		dest:	pkg.project_settings.prefix + 'js/vendor/'
	},

	cssVendor: {
		src:	[
				'./src/css/vendor/**/*.css',
				'./node_modules/jquery.appendgrid/jquery.appendGrid-1.7.1.min.css',
				'./node_modules/leaflet/dist/leaflet.css'
		],
		dest:	pkg.project_settings.prefix + 'css/vendor/'
	},

	fonts: {
		src:	'./src/fonts/**/*',
		dest:	pkg.project_settings.prefix + 'fonts/'
	},

	images: {
		src:	'./src/img/**/*',
		dest:	pkg.project_settings.prefix + 'img/',
		options: [
			$.imagemin.optipng({ optimizationLevel: 5 }),
			$.imagemin.svgo(svgoOptions)
		]
	},

	icons: {
		src:	'./src/icons/**/*.svg',
		dest:	pkg.project_settings.prefix + 'img/icons/',
		options: [
			$.imagemin.svgo(svgoOptions)
		]
	},

	sprite: {
		src: './src/icons/*.svg',
		dest: pkg.project_settings.prefix + 'img/',
		destFile:	'icons.svg',
		options: [
			$.imagemin.svgo(svgoOptions)
		]
	},

	favicons: {
		src: './src/img/favicon.svg',
		dest: pkg.project_settings.prefix + 'img/favicons/',
		background: '#ffffff'
	}
}



// Clean dist before building
function cleanDist(done) {
	return $.del([
		pkg.project_settings.prefix + '/'
	]);
  done();
}

/*
 *  Task: process SASS
 */
function cssDev(done) {
	return gulp
		.src(settings.css.srcMain)
		.pipe($.plumber({ errorHandler: onError}))
		.pipe($.sourcemaps.init())
		.pipe($.sass(settings.css.options.sass).on('error', $.sass.logError))
		.pipe($.autoprefixer(settings.css.options.autoprefixer))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest(settings.css.dest))
		.pipe($.browserSync.stream());
	done();
}

function cssProd(done) {
	return gulp
		.src(settings.css.srcMain)
		.pipe($.plumber({ errorHandler: onError }))
		.pipe($.sass(settings.css.options.sassProduction).on('error', $.sass.logError))
		.pipe($.autoprefixer(settings.css.options.autoprefixer))
		.pipe($.header(banner, { pkg: pkg }))
		.pipe(gulp.dest(settings.css.dest));
	done();
}

/*
 * Task: Concat and uglify Javascript
 */
function jsDev(done) {
	return gulp
		.src(settings.js.src)
		.pipe($.jsvalidate().on('error', function(jsvalidate) { console.log(jsvalidate.message); this.emit('end') }))
		.pipe($.sourcemaps.init())
		.pipe($.concat(settings.js.destFile))
		.pipe($.uglify().on('error', function(uglify) { console.log(uglify.message); this.emit('end') }))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest(settings.js.dest))
		.pipe($.browserSync.stream());
	done();
}

function jsProd(done) {
	return gulp
		.src(settings.js.src)
		.pipe($.jsvalidate().on('error', function(jsvalidate) { console.log(jsvalidate.message); this.emit('end') }))
		.pipe($.concat(settings.js.destFile))
		.pipe($.stripdebug())
		.pipe($.uglify().on('error', function(uglify) { console.log(uglify.message); this.emit('end') }))
		.pipe($.header(banner, { pkg: pkg }))
		.pipe(gulp.dest(settings.js.dest));
	done();
}



/*
 * Task: Uglify vendor Javascripts
 */
function jsVendor(done) {
	return gulp.src(settings.jsVendor.src)
		.pipe(gulp.dest(settings.jsVendor.dest));
    done();
}



function cssVendor(done) {
	return gulp.src(settings.cssVendor.src)
		.pipe(gulp.dest(settings.cssVendor.dest));
	done();
}



function fonts(done) {
	return gulp.src(settings.fonts.src)
		.pipe(gulp.dest(settings.fonts.dest));
    done();
}


/*
 * Task: create images
 * TODO: Check if optimization is more effectiv when it is done separately for all different image types(png, svg, jpg)
 */
function images(done) {
	// optimize all other images
	// TODO: It seems that plugin in don't overwrites existing files in destination folder!??
	return gulp.src(settings.images.src)
		.pipe($.newer(settings.images.dest))
		.pipe($.imagemin(settings.images.options, { verbose: true }))
		.pipe(gulp.dest(settings.images.dest));
	done();
}



function icons(done) {
	return gulp.src(settings.icons.src)
		.pipe($.newer(settings.icons.dest))
		.pipe($.imagemin(settings.icons.options))
		.pipe(gulp.dest(settings.icons.dest));
	done();
}


/*
 * Task: create sprites(SVG): optimize and concat SVG icons
 */
function sprite() {
	return gulp.src(settings.sprite.src)
		.pipe($.imagemin(settings.sprite.options))
		.pipe($.svgstore({
			inlineSvg: true
		}))
		.pipe($.rename(settings.sprite.destFile))
		.pipe(gulp.dest(settings.sprite.dest));
}



/*
 * Default TASK: Watch SASS and JAVASCRIPT files for changes,
 * build CSS file and inject into browser
 */
function gulpDefault(done) {

	$.browserSync.init(settings.browserSync);

	gulp.watch(settings.css.src, cssDev);
	gulp.watch(settings.js.src, jsDev);
  done();
}


/**
 * Generate favicons
 */
function favicons(done) {
	return gulp.src(settings.favicons.src)
		.pipe($.favicons({
			appName: pkg.name,
			appShortName: pkg.name,
			appDescription: pkg.description,
			developerName: pkg.author,
			developerUrl: pkg.repository.url,
			background: settings.favicons.background,
			path: settings.favicons.dest,
			url: pkg.project_settings.url,
			display: "standalone",
			orientation: "portrait",
			scope: "/",
			start_url: "/",
			version: pkg.version,
			logging: false,
			pipeHTML: false,
			replace: true,
			icons: {
				android: false,
				appleIcon: false,
				appleStartup: false,
				coast: false,
				firefox: false,
				windows: false,
				yandex: false,
				favicons: true
			}
		}))
		.pipe(gulp.dest(settings.favicons.dest))
	;
	done();
}

//var exec = require('child_process').exec;

/*
 * Task: Build all
 */
exports.buildDev = series(cleanDist, jsDev, jsVendor, cssDev, cssVendor, images, icons, fonts);
exports.buildProd = series(cleanDist, jsProd, jsVendor, cssProd, cssVendor, images, icons, fonts);

exports.default = gulpDefault;
exports.cleanDist = cleanDist;
exports.cssDev = cssDev;
exports.cssProd = cssProd;
exports.jsDev = jsDev;
exports.jsProd = jsProd;
exports.jsVendor = jsVendor;
exports.cssVendor = cssVendor;
exports.fonts = fonts;
exports.images = images;
exports.icons = icons;
