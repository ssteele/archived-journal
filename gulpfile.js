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

elixir(function(mix) {

    mix.less('app.less', 'resources/css');                          // compile less into css (input file, output folder)

    mix.styles([                                                    // combine compiled stylesheets
        'app.css',                                                  // ...specifying input (from less output)
    ], 'public/css/style.css', 'resources/css');                    // ...and output file, input folder

    mix.scripts([                                                   // combine compiled scripts
        'vendor/jquery-2.1.3.min.js',
        'vendor/bootstrap-3.3.1.min.js',
    ], 'public/js/vendor.js', 'resources/js');                      // ...and output file, input folder

    mix.scripts([
        'scripts.js'
    ], 'public/js/scripts.js', 'resources/js');

    mix.phpUnit();                                                  // trigger PHP unit tests: found in .../site/tests/

});
