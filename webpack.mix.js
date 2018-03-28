const mix = require('laravel-mix');
const loader = require('./lib/file-loader.js');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');
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

const bower_path = 'public/bower_components/';
const bower_components = [
  bower_path + 'chart.js/dist/Chart.js',
  bower_path + 'jquery/dist/jquery.js',
  bower_path + 'velocity/velocity.js',
  bower_path + 'moment/min/moment-with-locales.js',
  bower_path + 'angular/angular.js',
  bower_path + 'lumx/dist/lumx.js',
  bower_path + 'bootstrap/dist/js/bootstrap.js',
  bower_path + 'angular-ui-router/release/angular-ui-router.js',
  bower_path + 'angular-touch/angular-touch.js',
  bower_path + 'angular-animate/angular-animate.js',
  bower_path + 'ng-file-upload/ng-file-upload.js',
  bower_path + 'ng-file-upload/ng-file-upload-shim.js',
  bower_path + 'angular-locker/dist/angular-locker.js',
  bower_path + 'angular-chart.js/dist/angular-chart.js',
];

mix.styles(['public/app/styles/style.css',
            'public/app/styles/timeline.css',
            'public/app/styles/fonts.css'
          ],'public/app/css/app.min.css')
    .combine(bower_components, 'public/app/js/main.min.js')
    .js('resources/assets/js/app.js', 'public/app/js/app.min.js')
    .combine( loader.getFiles('/../resources/assets/js/controllers', '/resources/assets/js/controllers')
    , 'public/app/js/controllers.min.js')
    .combine(loader.getFiles('/../resources/assets/js/services', '/resources/assets/js/services')
    , 'public/app/js/services.min.js')
    .combine(loader.getFiles('/../resources/assets/js/filters', '/resources/assets/js/filters')
    , 'public/app/js/filters.min.js')
    .webpackConfig({
      plugins: [
        new CopyWebpackPlugin([{
          maxFileSize: 1000 * 100,
          from: 'resources/assets/images/svg',
          to: 'app/images/app-arts/svg'
        }]),
        new ImageminPlugin({
          maxFileSize: 1000 * 100,
          test: /\.(jpe?g|png|gif|svg)$/i,
          plugins: [
            imageminMozjpeg({
                quality: 80,
            })
          ]
        }),
        new CopyWebpackPlugin([{
          maxFileSize: 1000 * 1000,
          from: 'resources/assets/images/auspiciadores',
          to: 'app/images/app-arts/auspiciadores'
        }]),
        new ImageminPlugin({
          maxFileSize: 1000 * 100,
          test: /\.(jpeg|png|gif|svg)$/i,
          plugins: [
            imageminMozjpeg({
                quality: 70,
            })
          ]
        }),
      ]
    });
