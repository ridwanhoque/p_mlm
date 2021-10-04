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


mix.webpackConfig({
    output: {
        chunkFilename: 'js/chunks/[name].js'
    }
});

mix.options({
    hmrOptions: {
        host: 'mlmecom.test'
    }
});


mix.js('resources/js/dashboard.js', 'public/js')
   .sass('resources/sass/dashboard.scss', 'public/css')
    .js('resources/website/web.js', 'public/web');
