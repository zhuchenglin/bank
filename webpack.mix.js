const mix  = require('laravel-mix');

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
mix.js('resources/assets/js/admin/admin.js', 'public/js')
    .js('resources/assets/js/user/user.js', 'public/js')
    .extract(['vue', 'element-ui', 'vue-router'])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .copyDirectory('resources/assets/library/js','public/js')
    .copyDirectory('resources/assets/library/css','public/css');
   ;
if (mix.config.inProduction) {
    mix.version();
    mix.disableNotifications();
}