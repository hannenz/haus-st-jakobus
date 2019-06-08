/**
 * Default gulpfile for HALMA projects
 * 
 * Version 2017-08-22
 *
 * @see https://www.sitepoint.com/introduction-gulp-js/
 * @see https://nystudio107.com/blog/a-gulp-workflow-for-frontend-development-automation
 * @see https://nystudio107.com/blog/a-better-package-json-for-the-frontend
 */
'use strict';

// package vars
const pkg = require ('./package.json');

// gulp
const gulp = require ('gulp');

// Load all plugins in 'devDependencies' into the variable $
const $ = require('gulp-load-plugins')({
	pattern: ['*'],
	scope: ['devDependencies']
});

// Default error handler: Log to console
const onError = (err) => {
	console.log (err);
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



//array of gulp task names that should be included in "gulp build" task
var build =      ['clean:dist', 'js', 'jsvendor', 'css', 'cssvendor', 'images', 'sprite', 'icons', 'fonts'];
var build_prod = ['clean:dist', 'js-production', 'jsvendor', 'css-production', 'cssvendor', 'images', 'sprite', 'icons', 'fonts'];



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

// project settings (enhance if you need to ;-) )
var settings = {

	browserSync: {
		proxy:	'https://' + pkg.name + '.localhost',
		open: false,	// Don't open browser, change to "local" if you want or see https://browsersync.io/docs/options#option-open
		notify: false,	// Don't notify on every change
		https: {
			// key: '/Users/johannesbraun/server.key',
			// cert: '/Users/johannesbraun/server.crt'
			key: '/etc/ssl/private/ssl-cert-snakeoil.key',
			cert: '/etc/ssl/certs/ssl-cert-snakeoil.pem'
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
				outputStyle: 'nested',
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
			},

			autoprefixer: {
				browsers: ['last 2 versions', '>2%', 'IE 11']
			}
		}
	},

	js: {
		src:	'./src/js/*.js',
		dest:	pkg.project_settings.prefix + 'js/',
		destFile:	'main.min.js'
	},

	jsvendor: {
		src:	[
				'./src/js/vendor/**/*.js',
				'./node_modules/foundation-sites/dist/js/**/*.js',
				'./node_modules/jquery/dist/jquery.min.js',
				'./node_modules/jquery.appendgrid/jquery.appendGrid-1.7.1.min.js',
				'./node_modules/leaflet/dist/leaflet.js'
		],
		dest:	pkg.project_settings.prefix + 'js/vendor/'
	},

	cssvendor: {
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
			$.imagemin.optipng ({ optimizationLevel: 5 }),
			$.imagemin.svgo (svgoOptions)
		]
	},

	icons: {
		src:	'./src/icons/**/*.svg',
		dest:	pkg.project_settings.prefix + 'img/icons/',
		options: [
			$.imagemin.svgo (svgoOptions)
		]
	},

	sprite: {
		src:	'./src/icons/*.svg',
		dest:	pkg.project_settings.prefix + 'img/',
		destFile:	'icons.svg',
		options: [
			$.imagemin.svgo (svgoOptions)
		]
	}
}



// Clean dist before building
gulp.task ('clean:dist', function () {
	return $.del ([
		pkg.project_settings.prefix + '/'
	]);
})

/*
 *  Task: process SASS for development
 */
gulp.task('css', function (done) {
	return gulp
		.src(settings.css.srcMain)
		.pipe($.plumber({ errorHandler: onError}))

		.pipe($.sourcemaps.init())
		.pipe($.sass(settings.css.options.sass).on('error', $.sass.logError))
		.pipe($.autoprefixer(settings.css.options.autoprefixer))
		.pipe($.sourcemaps.write('./'))

		.pipe(gulp.dest(settings.css.dest))
		.pipe($.browserSync.stream())
	;	
	done();
});

/*
 *  Task: process SASS PRODUCTION
 */
gulp.task('css-production', function (done) {
	return gulp
		.src(settings.css.srcMain)
		.pipe($.sass(settings.css.options.sassProduction).on('error', $.sass.logError))
		.pipe($.autoprefixer(settings.css.options.autoprefixer))
		.pipe($.header(banner, {pkg: pkg}))
		.pipe(gulp.dest(settings.css.dest))
	;	
	done();
});



/*
 * Task: Concat and uglify Javascript
 */
gulp.task('js', function() {
	return gulp.src(settings.js.src)
		.pipe($.jsvalidate().on('error', function(jsvalidate) { console.log (jsvalidate.message); this.emit('end') }))
		.pipe($.sourcemaps.init())
		.pipe($.concat(settings.js.destFile))
		// .pipe($.uglify().on('error', function(uglify) { console.log (uglify.message); this.emit('end') }))
		// .pipe($.header(banner, { pkg: pkg }))
		.pipe($.sourcemaps.write('./'))
		.pipe(gulp.dest(settings.js.dest))
		.pipe($.browserSync.stream())
	;
});

/*
 * Task: Concat and uglify Javascript for PRODUCTION
 */
gulp.task('js-production', function() {
	return gulp.src(settings.js.src)
		.pipe($.jsvalidate().on('error', function(jsvalidate) { console.log (jsvalidate.message); this.emit('end') }))
		.pipe($.concat(settings.js.destFile))
		.pipe($.stripDebug())
		.pipe($.uglify().on('error', function(uglify) { console.log (uglify.message); this.emit('end') }))
		.pipe($.header(banner, { pkg: pkg }))
		.pipe(gulp.dest(settings.js.dest))
	;
});



/*
 * Task: Uglify vendor Javascripts
 */
gulp.task('jsvendor', function() {
	return gulp.src(settings.jsvendor.src)
		.pipe(gulp.dest(settings.jsvendor.dest))
	;
});



gulp.task('cssvendor', function() {
	return gulp.src(settings.cssvendor.src)
		.pipe(gulp.dest(settings.cssvendor.dest))
	;
});



gulp.task ('fonts', function () {
	return gulp.src (settings.fonts.src)
		.pipe (gulp.dest (settings.fonts.dest))
	;
});


/*
 * Task: create images
 * TODO: Check if optimization is more effectiv when it is done separately for all different image types (png, svg, jpg)
 */
gulp.task('images', function(done) {
	// optimize all other images
	// TODO: It seems that plugin in don't overwrites existing files in destination folder!??
	return gulp.src(settings.images.src)
		.pipe($.newer(settings.images.dest))
		.pipe($.imagemin(settings.images.options, { verbose: true }))
		.pipe(gulp.dest(settings.images.dest))
	;
	done();
});



gulp.task('icons', function(done) {
	return gulp.src(settings.icons.src)
		.pipe($.newer(settings.icons.dest))
		.pipe($.imagemin(settings.icons.options))
		.pipe(gulp.dest(settings.icons.dest))
	;
	done();
});


/*
 * Task: create sprites(SVG): optimize and concat SVG icons
 */
gulp.task('sprite', function(done) {
	return gulp.src(settings.sprite.src)
		.pipe($.imagemin (settings.sprite.options))
		.pipe($.svgstore({
			inlineSvg: true
		}))
		.pipe(gulp.dest(settings.sprite.dest))
	;
	done();
});



/*
 * Default TASK: Watch SASS and JAVASCRIPT files for changes,
 * build CSS file and inject into browser
 */
gulp.task('default', gulp.series('css', function () {

	// gutil.log ("Running watch task");
	$.browserSync.init(settings.browserSync);

	gulp.watch(settings.css.src, gulp.series('css'));
	gulp.watch(settings.js.src, gulp.series('js'));

}));

var exec = require('child_process').exec;

/*
 * Task: Build all
 */
gulp.task('build', gulp.series(build));
gulp.task('build-prod', gulp.series(build_prod));
// gulp.task('deploy', gulp.series(build, 'deploy-production'));

