const mix = require("laravel-mix");

mix.setPublicPath('./src/public');
mix.js('src/resources/assets/js/app.js','js/app.js')