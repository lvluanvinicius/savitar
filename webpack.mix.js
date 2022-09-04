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

 mix.
 postCss("resources/views/admin/assets/css/admin.custom.css", "public/assets/admin/css")

 .copyDirectory("resources/views/admin/assets/img", "public/assets/admin/img")
 .copy("resources/views/admin/assets/img/savitar.ico", "public/favicons/favicon.ico")

. js("resources/views/admin/assets/js/admin.custom.js", "public/assets/admin/js");
