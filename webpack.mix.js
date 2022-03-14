const mix = require('laravel-mix');
// let url = process.env.APP_URL.replace(/(^\w+:|^)\/\//, '');
const fs = require("fs");
const path = require("path");

const homeDir = process.env.HOME;
const host = process.env.APP_DOMAIN
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

mix
    .webpackConfig(webpack => {
        return {
            plugins: [
                new webpack.ProvidePlugin({
                    'window.Quill': 'quill',
                    'Quill': 'quill'
                })
            ]
        };
    })
    .js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .sourceMaps();
