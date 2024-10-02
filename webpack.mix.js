mix.js('resources/js/app.js', 'public/js')
    .vue() // This is crucial to compile Vue components
    .sass('resources/sass/app.scss', 'public/css');
