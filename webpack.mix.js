const mix = require('laravel-mix');
const path = require('path');
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

mix.disableNotifications();
mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]).webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js/src'),
                '@views': path.resolve(__dirname, 'resources/js/src/views'),
                '@core': path.resolve(__dirname, 'resources/js/src/Core'),
                '@css': path.resolve(__dirname, 'resources/css')
            },

        },
        output: {
            publicPath: `${process.env.MIX_LOCAL_FOLDER}`,
            chunkFilename: 'js/chunks/[name].[chunkhash].js',
        },
    }).options({
        processCssUrls: false
    });
