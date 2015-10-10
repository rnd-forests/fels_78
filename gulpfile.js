var elixir = require('laravel-elixir');

elixir(function (mix) {
    mix.sass('app.scss', 'public/css/app');

    mix.styles([
        'bootstrap/dist/css/bootstrap.min.css',
        'fontawesome/css/font-awesome.min.css',
        'sweetalert/dist/sweetalert.css',
    ], 'public/css/vendor.css', 'vendor/bower-components');

    mix.styles([
        'vendor.css',
        'app/app.css'
    ], null, 'public/css');

    mix.scripts([
        'jquery/dist/jquery.min.js',
        'bootstrap/dist/js/bootstrap.min.js',
        'sweetalert/dist/sweetalert.min.js',
    ], 'public/js/vendor.js', 'vendor/bower-components');

    mix.scripts([
        'vendor.js',
        'app/app.js'
    ], null, 'public/js');

    mix.version([
        'public/css/all.css',
        'public/js/all.js'
    ]);
});
