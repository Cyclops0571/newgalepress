const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass([
        'website/font-awesome.scss',
        'website/owl.carousel.scss',
        'website/owl.theme.scss',
        'website/slit-slider-style.scss',
        'website/slit-slider-custom.scss',
        'website/idangerous.swiper.scss',
        'website/yamm.scss',
        'website/animate.scss',
        'website/prettyPhoto.scss',
        'website/bootstrap-slider.scss',
        'website/device-mockups2.scss',
        'website/bootstrap.3.3.1.scss',
        'website/main.scss',
        'website/main-responsive.scss',
        'website/theme_royalblue.scss',
        'website/myWebsiteStyles.scss'
    ], 'public/css/website.css');

    mix.scripts([
        'website/modernizr.js',
        'jquery.js',
        'jquery.cookie.js',
        'website/queryloader2.min.js',
        'website/owl.carousel.js',
        'website/jquery.ba-cond.min.js',
        'website/jquery.slitslider.js',
        'website/idangerous.swiper.js',
        'website/jquery.fitvids.js',
        'website/jquery.countTo.js',
        'website/TweenMax.min.js',
        'website/ScrollToPlugin.min.js',
        'website/jquery.scrollmagic.min.js',
        'website/jquery.easypiechart.js',
        'website/jquery.validate.js',
        'website/wow.min.js',
        'website/jquery.placeholder.js',
        'website/jquery.easing.1.3.min.js',
        'website/jquery.waitforimages.min.js',
        'website/jquery.prettyPhoto.js',
        'website/imagesloaded.pkgd.min.js',
        'website/isotope.pkgd.min.js',
        'website/jquery.fillparent.min.js',
        'website/raphael-min.js',
        'website/bootstrap.js',
        'website/jquery.bootstrap-touchspin.min.js',
        'website/bootstrap-slider.js',
        'website/bootstrap-rating-input.js',
        'website/bootstrap-hover-dropdown.min.js',
        'website/jquery.gmap.min.js',
        'website/circle_diagram.js',
        'website/main.js',
    ], 'public/js/website.js');

    mix.sass('website/font-awesome.scss');
    mix.version('/css/website.css');
    mix.version('/js/website.js');

    mix.styles([
        'bootstrap.min.css',
        'bootstrap-editable.css',
        'jquery-ui.min.css',
        'font-awesome.min.css',
        'select2.css',
        'stylesheet.css',
        'backgrounds.css',
        'themes.css',
        'general.css',
        'myApp.css',
        'mystyles.css',
        'btn_interactive.css',
        'device-mockups2.css',
        'bootstrap-colorpicker.min.css'],
        'public/css/galepress-all.css'
    );
    mix.version('/css/galepress-all.css');

   //mix.sass('animate.scss').version();
   /*mix.webpack('app.js');*/
   // mix.version('css/mystyles.css'); //elixir('css/styles.css')

});
