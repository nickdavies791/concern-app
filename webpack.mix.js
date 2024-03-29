const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/argon.min.js', 'public/js');
mix.js('resources/js/Chart.min.js', 'public/js').version();
mix.js('resources/js/body-map.js', 'public/js');
mix.copy('resources/images', 'public/images');
mix.copy('resources/fonts', 'public/fonts');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

