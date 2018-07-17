let mix = require('laravel-mix');

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

mix.babel([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    'node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js',
    'node_modules/select2/dist/js/select2.full.min.js',
    'resources/assets/js/common/jquery.function.js',
    'resources/assets/js/common/Events.js',
    'resources/assets/js/common/App.js',
    'resources/assets/js/common/layout.js',
    'resources/assets/js/common/UrlConstant.js',
    'resources/assets/js/common/MSG.js',
    'node_modules/jquery-ui/ui/widgets/datepicker.js',
    'node_modules/jquery-ui/ui/i18n/datepicker-ja.js',
    'resources/assets/js/common/date-picker.js',
    'resources/assets/js/common/time-picker.js',
    'resources/assets/js/common/moment.js',
    'resources/assets/js/common/moment-ja.js',
    'resources/assets/js/common/bootstrap-datetimepicker.min.js',
    'resources/assets/js/common/resizable-tables.js'
], 'public/js/vendor.js')
    .babel([
        'node_modules/jquery-pjax/jquery.pjax.js',
        'resources/assets/js/common/mustache.min.js',
        'resources/assets/js/common/jquery.alphanum.js',
        'node_modules/trumbowyg/dist/trumbowyg.min.js',
        'node_modules/trumbowyg/dist/plugins/colors/trumbowyg.colors.min.js',
        'node_modules/trumbowyg/dist/langs/ja.min.js',
        'resources/assets/js/common/editor.js',
        'resources/assets/js/image64-upload.js'
    ], 'public/js/content.js')
    .babel([
        'resources/assets/js/users-general-list-user.js'
    ], 'public/js/users-general-list-user.js')
    .babel([
        'resources/assets/js/company-general-list-company.js'
    ], 'public/js/company-general-list-company.js')
    .babel([
        'resources/assets/js/company-general.js'
    ], 'public/js/company-general.js')
    .babel([
        'resources/assets/js/create-billing-paper.js'
    ], 'public/js/create-billing-paper.js')
    .babel([
        'resources/assets/js/ship-general.js'
    ], 'public/js/ship-general.js')
    .babel([
    ], 'public/js/datetimepicker-general.js')
    .babel([
        'resources/assets/js/contract.js'
    ], 'public/js/contract.js')
    .babel([
        'resources/assets/js/history-billing.js'
    ], 'public/js/history-billing.js')
    .babel([
        'resources/assets/js/approve.js'
    ], 'public/js/approve.js')
    .babel([
        'node_modules/chart.js/dist/Chart.min.js',
        'resources/assets/js/statistic-billing.js'
    ], 'public/js/statistic-billing.js')
    .babel([
        'node_modules/mustache/mustache.min.js',
        'node_modules/jquery-pjax/jquery.pjax.js',
        'resources/assets/js/ship-contract.js'
    ], 'public/js/ship-contract.js')
   .babel([
        'resources/assets/js/search-service-master.js'
    ], 'public/js/search-service-master.js')
    .babel([
        'resources/assets/js/search-ship-master.js'
    ], 'public/js/search-ship-master.js')
    .sass('resources/assets/sass/vendor.scss', 'public/css')
    .sass('resources/assets/sass/auth.scss', 'public/css')
    .sass('resources/assets/sass/user-general.scss', 'public/css')
    .sass('resources/assets/sass/company-general.scss', 'public/css')
    .sass('resources/assets/sass/ship-general.scss', 'public/css')
    .sass('resources/assets/sass/ship-contract.scss', 'public/css')
    .sass('resources/assets/sass/contract.scss', 'public/css')
    .sass('resources/assets/sass/create-billing-paper.scss', 'public/css')
    .sass('resources/assets/sass/history-billing.scss', 'public/css')
    .sass('resources/assets/sass/statistic-billing.scss', 'public/css')
    .sass('resources/assets/sass/spot.scss', 'public/css')
    .sass('resources/assets/sass/approve.scss', 'public/css')
    .sass('resources/assets/sass/preview-billing-paper.scss', 'public/css')
    .sass('resources/assets/sass/exception.scss', 'public/css')
    .copyDirectory('resources/images/common', 'public/images/common');
