var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');
//   plugin to copy images to build folder automatically
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addPlugin(new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/))


    //.enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
     .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
     .addEntry('app', './assets/js/app.js')
     .addEntry('main', './assets/js/main.js')
    .addEntry('calendar', './assets/js/fullcalendar-data.js')
    .addEntry('timePicker', './assets/js/form-picker-data.js')
     .addEntry('login', './assets/js/login.js')





     .enableBuildNotifications()
    // .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
     .autoProvidejQuery()

     .addPlugin(new CopyWebpackPlugin([
         // copies to output directory/static
         { from: './assets/static', to : 'static' }
         ]))

    .autoProvideVariables({
        'window.Tether': 'tether'
    })


;

module.exports = Encore.getWebpackConfig();

