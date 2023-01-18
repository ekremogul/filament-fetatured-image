const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss');

mix
    .sass('./resources/css/featured-image.scss', './resources/dist')
    .options({
        postCss: [
            tailwindcss('./tailwind.config.js')
        ]
    })


