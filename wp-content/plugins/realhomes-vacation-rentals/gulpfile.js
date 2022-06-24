/*** Require Modules ***/
let { task } = gulp = require('gulp');
let sass = require('gulp-sass');
let sourcemaps = require('gulp-sourcemaps');
let notify = require('gulp-notify');
let browserSync = require('browser-sync').create();
let reload = browserSync.reload;
// let plumber = require('gulp-plumber');
let zip = require('gulp-zip');
// let rename = require("gulp-rename");

/*** Config ***/
let styleWatchFiles = 'assets/sass/**/*.scss';
let PHPWatchFiles = './**/*.php';
let projectURL = 'realhomes.o/wp-admin'

/**
 * Task: `watch`
 *
 * Watches for file changes and runs specific tasks.
 */
task('watch', function () {
    gulp.watch(PHPWatchFiles, reload); // Reload browser on PHP file changes.
    gulp.watch(styleWatchFiles, gulp.series('styles')); // Load on SCSS file changes.
});

/**
 * Task: `browser-sync`.
 *
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * This task does the following:
 *    1. Sets the project URL
 *    2. Sets inject CSS
 *    3. You may define a custom port
 *    4. You may want to stop the browser from opening automatically
 */
gulp.task('browser-sync', function () {
    browserSync.init({

        proxy: projectURL,
        open: true,
        injectChanges: true,

        // Use a specific port (instead of the one auto-detected by Browsersync).
        // port: 7000,

    });
});

/**
 * Task: `styles`
 *
 * Compile sass files to css.
 */
task('styles', function (done) {

    let cssDestination = 'assets/css';

    gulp.src([styleWatchFiles])
        // .pipe(sourcemaps.init())
        .pipe(sass({
            errLogToConsole: true,
            outputStyle: 'compact',
            // outputStyle: 'compressed',
            // outputStyle: 'nested',
            // outputStyle: 'expanded',
            precision: 10
        }))
        .on('error', console.error.bind(console))
        // .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(cssDestination))
        .pipe(browserSync.stream()) // Reloads style.css if that is enqueued.
        .pipe(gulp.dest(cssDestination))
        .pipe( browserSync.reload({stream: true}) )
        .pipe(notify({message: 'TASK: "styles" Completed! 💯', onLast: true}));
    done();
});

/**
 * Build plugin zip
 */
gulp.task('zip', function () {
    return gulp.src( [
        // Include
        './**/*',
        // Exclude
        '!./**/.DS_Store',
        '!./**/*.map',
        '!./**/*.scss',
        '!./node_modules/**',
        '!./node_modules',
        '!./package.json',
        '!./package-lock.json',
        '!./gulpfile.js'
    ])
        .pipe ( zip ( 'realhomes-vacation-rentals.zip' ) )
        .pipe ( gulp.dest ( '../../' ) )
        .pipe ( notify ( {
            message : 'Realhomes Vacation Rentals plugin zip is ready.',
            onLast : true
        } ) );
});