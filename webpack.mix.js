// webpack.mix.js
const mix = require('laravel-mix');

mix
    // 1. Compile your main JS file (which imports Alpine, Bootstrap, teachers.js, etc.)
    .js('resources/js/app.js', 'public/js')

    // 2. Compile your SCSS (where you @import Tailwind + vos styles)
    .sass('resources/scss/app.scss', 'public/css')

    // 3. Cache‑busting
    .version();
