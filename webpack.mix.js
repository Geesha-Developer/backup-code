mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/admin-lte/dist/css/adminlte.min.css', 'public/css')
    .copy('node_modules/admin-lte/dist/js/adminlte.min.js', 'public/js');
    
