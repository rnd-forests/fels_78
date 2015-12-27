var gulp      = require('gulp');
var concat    = require('gulp-concat');
var notify    = require('gulp-notify');
var minify    = require('gulp-minify-css');
var uglify    = require('gulp-uglify');
var gulpif    = require('gulp-if');
var minimatch = require("minimatch");
var Elixir    = require('laravel-elixir');
var Task      = Elixir.Task;

var paths = {
    "bowerPath": './vendor/bower-components/'
};

var bowerCssDir = [
    'sweetalert/dist/sweetalert.css',
    'bootstrap/dist/css/bootstrap.min.css',
    'bootstrap-social/bootstrap-social.css',
    'font-awesome/css/font-awesome.min.css'
];

var bowerJsDir = [
    'jquery/dist/jquery.min.js',
    'bootstrap/dist/js/bootstrap.min.js',
    'sweetalert/dist/sweetalert.min.js',
    'jquery.countdown/dist/jquery.countdown.min.js'
];

// Combine and minify Bower dependencies
Elixir.extend('bowerify', function (relativeDir, outputFile, outputDir) {
    new Task('bowerify', function () {
        var absoluteDir = relativeDir.map(function (dir) {
            return paths.bowerPath + dir;
        });
        var isCSS = minimatch(relativeDir[0], '*.css', {matchBase: true});
        return gulp.src(absoluteDir)
            .pipe(concat(outputFile))
            .pipe(gulpif(isCSS, minify(), uglify()))
            .pipe(gulp.dest(outputDir))
            .pipe(notify('Combined Bower dependencies!'));
    });
});

Elixir(function (mix) {
    mix.sass('app.sass');
    mix.bowerify(bowerCssDir, 'bower-all.css', 'public/css');
    mix.styles(['bower-all.css', 'app.css'], null, 'public/css');

    mix.coffee('app.coffee');
    mix.bowerify(bowerJsDir, 'bower-all.js', 'public/js');
    mix.scripts(['bower-all.js', 'app.js'], null, 'public/js');

    mix.version(['public/css/all.css', 'public/js/all.js']);
});
