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
// mix.postCss('resources/css/app.css', 'public/css/app.css', [
//      require('tailwindcss'),
// ])

//mix.copy(['public/css/app.css'], 'resources/js/components/App.css');

mix.js('resources/js/app.js', 'public/js/app.js')
  .react()

mix.copy(['public/js/app.js'], 'resources/views/embed.php');
// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);