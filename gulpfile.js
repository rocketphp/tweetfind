var webroot = './public/html/';
var assets_dir = './src/assets/';

/* Require */
var gulp = require('gulp'),
    plumber = require('gulp-plumber');

// sass
var sass = require('gulp-sass'),
    compass = require('gulp-compass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifyCSS = require('gulp-minify-css'),
    rename = require('gulp-rename');

// browserify
var browserify = require('gulp-browserify');

// image minification
var changed = require('gulp-changed'),
    imagemin = require('gulp-imagemin');

// browsersync
var browserSync = require('browser-sync');


/* OnError */
var onError = function (err) {   
  console.log(err);
  this.emit('end');
};
 
/* Compass */
gulp.task('compass', function() {
  gulp.src(assets_dir + 'sass/**/*.scss')
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(compass({
      config_file: './config.rb',
      css: webroot + 'css',
      sass: assets_dir + 'sass'
    }))
    .pipe(gulp.dest(webroot + 'css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifyCSS())
    .pipe(gulp.dest(webroot + 'css'));
});

/* Sass */
gulp.task('sass', function() {
  return gulp.src([assets_dir + 'sass/**/*.scss'])
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(sass({ style: 'expanded' }))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
    .pipe(gulp.dest(webroot + 'css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifyCSS())
    .pipe(gulp.dest(webroot + 'css'))
    .pipe(browserSync.stream());
});

/* Browserify */
gulp.task('browserify', function() {
  gulp.src(assets_dir + 'js/app.js')
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(browserify({
      insertGlobals : true,
      debug : !gulp.env.production
    }))
    .pipe(gulp.dest(webroot + 'js'))
});

/* Minify New Images */
gulp.task('imagemin', function() {
  var imgSrc = assets_dir + 'img/**/*',
    imgDst = webroot + 'img';

  gulp.src(imgSrc)
    .pipe(plumber({
      errorHandler: onError
    }))
    .pipe(changed(imgDst))
    .pipe(imagemin())
    .pipe(gulp.dest(imgDst));
});

/* Watch */
gulp.task('watch', function() {

  // sass
  gulp.watch(assets_dir + 'sass/**/*.scss', ['sass']);
  gulp.watch(assets_dir + 'sass/_settings.scss', ['compass']);
  gulp.watch(assets_dir + 'sass/_vendor.scss', ['compass']);

  // browserify
  gulp.watch(assets_dir + 'js/**/*.js', ['browserify']);

  // images
  gulp.watch(assets_dir + 'img/**/*', ['imagemin']);

});

/* Default Task */ 
gulp.task('default', ['compass', 'browserify', 'watch'], function() {

});