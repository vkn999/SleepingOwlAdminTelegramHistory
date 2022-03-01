let mix = require('laravel-mix');

mix

.less('resources/assets/less/common.less',      'public/default/css/admin-app.css')
    .options({
        publicPath: 'public/default',
        processCssUrls: false,
        // fileLoaderDirs: {
        //              fonts: 'packages/sleepingowl/default'
        //          }
    })

.js('resources/assets/js_owl/app.js',           'public/default/js/admin-app.js')
.js('resources/assets/js_owl/vue_init.js',      'public/default/js/vue.js')
.js('resources/assets/js_owl/modules_load.js',  'public/default/js/modules.js')

.copy('resources/assets/fonts',                 'public/default/fonts')
.copy('node_modules/bootstrap/fonts',           'public/default/fonts')
.copy('node_modules/font-awesome/fonts',        'public/default/fonts');

