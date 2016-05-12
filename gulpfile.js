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
        'vendor/custom-scroller/jquery.mCustomScrollbar.concat.min.js',

        'setup.js', //Sets CSRF token
        'search.js',
        'cart.js',
        'order.js',
        'address.js',
        'events.js',
        'postcode.js'
    ], 'public/dist/js/app.js');

    mix.scripts([
        'vendor/adminLTE/adminLTE.js',
        'vendor/Chart.js/Chart.js'
    ], 'public/dist/js/admin.js');

    mix.scripts([
        'vendor/formvalidation/formValidation.min.js',
        'vendor/formvalidation/bootstrap.js',
        'vendor/formvalidation/language/it_IT.js'
    ], 'public/dist/js/formvalidation.js');


    mix.version([
        'dist/assets/css/app.css',
        'dist/assets/css/admin/admin.css',
        'dist/js/app.js',
        'dist/js/admin.js',
        'dist/js/formvalidation.js'
    ]);
});
