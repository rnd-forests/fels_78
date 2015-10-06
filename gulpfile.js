var elixir = require('laravel-elixir');

elixir(function (mix) {
    mix.copy(
        'vendor/bower_components/jquery/dist/jquery.min.js',
        'public/js/vendor/jquery.min.js'
    );
    mix.copy(
        'vendor/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'public/js/vendor/bootstrap.min.js'
    );
    mix.copy(
        'vendor/bower_components/sweetalert/dist/sweetalert.min.js',
        'public/js/vendor/sweetalert.min.js'
    );

    mix.copy(
        'vendor/bower_components/bootstrap-sass-official/assets/stylesheets/bootstrap/',
        'resources/assets/sass/bootstrap/'
    );
    mix.copy(
        'vendor/bower_components/bootstrap-sass-official/assets/stylesheets/_bootstrap.scss',
        'resources/assets/sass/_bootstrap.scss'
    );
    mix.copy(
        'vendor/bower_components/sweetalert/dist/sweetalert.css',
        'public/css/vendor/sweetalert.css'
    );

    mix.copy(
        'vendor/bower_components/fontawesome/fonts',
        'public/fonts/font-awesome'
    );

    mix.sass('app.scss', 'public/css/app');
    mix.styles([
        'vendor/font-awesome.css',
        'vendor/sweetalert.css'
    ], 'public/css/vendor.css', 'public/css');
    mix.styles([
        'app/app.css',
        'vendor.css'
    ], null, 'public/css');

    mix.scripts([
        'vendor/jquery.min.js',
        'vendor/bootstrap.min.js',
        'vendor/sweetalert.min.js'
    ], 'public/js/vendor.js', 'public/js');
    mix.scripts([
        'vendor.js',
        'app/app.js'
    ], null, 'public/js');

    mix.version(['public/css/all.css', 'public/js/all.js']);
});
