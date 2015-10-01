var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('app.scss', 'public/css/app');

    mix.stylesIn('public/css/vendor', 'public/css/vendor.css');
    mix.styles(['app/app.css', 'vendor.css'], null, 'public/css');

    mix.scriptsIn('public/js/vendor', 'public/js/vendor.js');
    mix.scripts(['vendor.js', 'app/app.js'], null, 'public/js');

    mix.version(['public/css/all.css', 'public/js/all.js']);
});
