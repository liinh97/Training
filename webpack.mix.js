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

// mix.copy([
//     'node_modules/jquery/dist/jquery.js',
//     'node_modules/jquery-confirm/js/jquery-confirm.js'
// ], 'public/js').copy('node_modules/jquery-confirm/css/jquery-confirm.css', 'public/css');

const input = 'resources/sass/';
const output = 'public/css/';
const fs = require('fs');
const files = fs.readdirSync(input);

files.map(item => {
    if(item.includes('.')){
        mix.sass(input + item, output).disableSuccessNotifications();
    }else{
        const childFiles = fs.readdirSync(input + item);
        childFiles.map(childItem => {
            mix.sass(input + item + '/' + childItem, output + item).disableSuccessNotifications();
        });
    }
});
