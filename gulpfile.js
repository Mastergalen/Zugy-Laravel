var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass('app.scss', 'public/dist/assets/css');
    mix.sass('admin/admin.scss', 'public/dist/assets/css/admin');

    mix.scripts([
        /*
        * Vendor
        */
        'vendor/pjax/jquery.pjax.js',
        'vendor/sweetalert/sweetalert-dev.js',

        'search.js',
        'cart.js',
        'events.js',
    ], 'public/dist/js/app.js')
});
