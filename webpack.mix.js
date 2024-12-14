const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue() // Add Vue support here
   .postCss('resources/css/app.css', 'public/css', [
       //
   ]);
