mix = require('laravel-mix');
require('laravel-browser-sync');
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

//.js('resources/assets/js/app.js', 'public/js')

mix.sass('resources/assets/sass/style.scss', 'public/frontend/css');

mix.browserSync({
    proxy: 'application-cart.app'
})





