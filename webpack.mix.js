const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */



mix.
    postCss("resources/views/admin/assets/css/admin.custom.css", "public/assets/admin/css")

    .copyDirectory("resources/views/admin/assets/img", "public/assets/admin/img")

   . js("resources/views/admin/assets/js/admin.custom.js", "public/assets/admin/js")
